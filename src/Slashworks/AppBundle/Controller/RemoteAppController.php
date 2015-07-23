<?php
    /**
     *
     *          _           _                       _
     *         | |         | |                     | |
     *      ___| | __ _ ___| |____      _____  _ __| | _____
     *     / __| |/ _` / __| '_ \ \ /\ / / _ \| '__| |/ / __|
     *     \__ \ | (_| \__ \ | | \ V  V / (_) | |  |   <\__ \
     *     |___/_|\__,_|___/_| |_|\_/\_/ \___/|_|  |_|\_\___/
     *                                        web development
     *
     *     http://www.slash-works.de </> hallo@slash-works.de
     *
     *
     * @author      rwollenburg
     * @copyright   rwollenburg@slashworks
     * @since       06.01.15 10:26
     * @package     Slashworks\AppBundle
     *
     */

    namespace Slashworks\AppBundle\Controller;

    use Slashworks\AppBundle\Command\ApiCommand;
    use Slashworks\AppBundle\Form\Type\RemoteAppType;
    use Slashworks\AppBundle\Model\ApiLogQuery;
    use Slashworks\AppBundle\Model\RemoteApp;
    use Slashworks\AppBundle\Model\RemoteAppQuery;
    use Slashworks\AppBundle\Model\RemoteHistoryContaoQuery;
    use Slashworks\AppBundle\Services\Api;
    use Slashworks\BackendBundle\Helper\InstallHelper;
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Slashworks\libs\UnzipFile;
    use Slashworks\libs\Zip;
    use Symfony\Component\Console\Input\ArgvInput;
    use Symfony\Component\Console\Output\BufferedOutput;
    use Symfony\Component\Console\Output\ConsoleOutput;
    use Symfony\Component\Console\Output\NullOutput;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Core\Exception\AccessDeniedException;

    require(__DIR__ . "/../Resources/private/api/zip.lib.php");

    /**
     * Class RemoteAppController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class RemoteAppController extends AppController
    {

        /**
         * Lists all RemoteApp entities.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction()
        {


            $aRemoteApps = RemoteAppQuery::create()->find();

            return $this->render('SlashworksAppBundle:RemoteApp:index.html.twig', array(
                'entities' => $aRemoteApps,
            ));
        }


        /**
         * Get data as json for remoteapp-list
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Slashworks\AppBundle\Controller\Response
         */
        public function indexDataAction(Request $request)
        {

            $aRemoteApps = RemoteAppQuery::create()->find();
            $sResult     = $this->renderView('SlashworksAppBundle:RemoteApp:data.json.twig', array(
                'entities' => $aRemoteApps,
            ));

            $response = new Response($sResult);
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }


        /**
         * show details for remoteapp
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function detailsAction($id)
        {

            $aRemoteApps       = RemoteAppQuery::create()->findOneById($id);
            $aRemoteAppHistory = $aRemoteApps->getRemoteHistoryContaoAsArray();

            return $this->render('SlashworksAppBundle:RemoteApp:details.html.twig', array(
                'remoteapp'        => $aRemoteApps,
                'remoteappHistory' => $aRemoteAppHistory
            ));
        }


        /**
         * get initial module from licenseserver
         *
         * @param $id
         *
         * @throws \Exception
         * @throws \PropelException
         * @throws \Slashworks\AppBundle\Controller\AccessDeniedException
         * @throws \Slashworks\libs\Exception
         */
        public function generateInitialApiZipAction($id)
        {

            /** @var RemoteApp $oRemoteApp */
            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);
            if (!$this->check4Client($oRemoteApp->getCustomerId())) {
                throw new AccessDeniedException();
            }

            if ($oRemoteApp === null) {
                throw $this->createNotFoundException('Unable to find RemoteApp entity.');
            }

            // get lico url
            $sLico = SystemSettings::get("lico");


            // build url and make call
            $lico       = $sLico . "/api/generate/module/" . base64_encode($this->_getSiteURL()) . "/" . base64_encode($oRemoteApp->getDomain());
            $sData      = @file_get_contents($lico);
            $sPublicKey = "";
            foreach ($http_response_header as $sHead) {
                if (stristr($sHead, "pk:")) {
                    $sPublicKey = substr($sHead, strpos($sHead, "-"));
                    $oRemoteApp->setPublicKey($sPublicKey);
                    $oRemoteApp->save();
                }
            }

            // unzip file ,add private key and rezip for download
            if (!empty($sPublicKey) && !empty($sData)) {

                // unzip enerated module to add public control key
                $aFiles = UnzipFile::read($sData);

                // add control key
                $aFiles[] = array(
                    "name"  => "control.key",
                    "dir"   => "server/private",
                    "mtime" => time(),
                    "data"  => file_get_contents(__DIR__ . "/../Resources/private/api/keys/server/public.key")
                );

                $oZip      = new Zip();
                Zip::$temp = __DIR__ . "/../Resources/private/tmp/";
                foreach ($aFiles as $aFile) {
                    $oZip->addFile($aFile['data'], $aFile['dir'] . "/" . $aFile['name']);
                }

                $sFileName = "swControl";
                $oZip->sendZip($sFileName . "_api.zip", "application/zip", $sFileName . ".zip");
            } else {
                $aData = json_decode($sData, true);
                if (empty($aData)) {
                    $this->get('logger')->error($this->get("translator")->trans("license.update.failed_lico"), array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                    $sHtml = "<script>alert('" . $this->get("translator")->trans("license.update.failed_lico") . "');</script>";
                } else {
                    if (isset($aData['message'])) {
                        $this->get('logger')->error( $aData['message'], array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                        $sHtml = "<script>alert('" . $aData['message'] . "');</script>";
                    } else {
                        $this->get('logger')->error($this->get("translator")->trans("license.update.failed_lico"), array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                        $sHtml = "<script>alert('" . $this->get("translator")->trans("license.update.failed_lico") . "');</script>";
                    }
                }
                echo $sHtml;
            }
            die();
        }


        /**
         * Update monitoring module
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         */
        public function initUpdateCallAction($id)
        {

            return $this->initInstallCallAction($id);
        }


        /**
         * initiate installation of complete monitoring module
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         */
        public function initInstallCallAction($id)
        {

            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);
            $sResult    = array(
                "success" => false,
                "message" => ""
            );
            try {
                $this->get("API");
                $mResult = Api::call("doInstall", array(), $oRemoteApp->getUpdateUrl(), $oRemoteApp->getPublicKey(), $oRemoteApp);
                if (!empty($mResult)) {
                    if (!isset($mResult['result']['result'])) {
                        throw new \Exception($this->get("translator")->trans("remote_app.api.init.error"));
                    }

                    if ($mResult['result']['result'] == true) {

                        $sResult['success'] = true;
                        $sResult['message'] = $this->get("translator")->trans("remote_app.api.update.successful");

                        $this->get('logger')->info("Api-Call successful", array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName()));

                        $oRemoteApp->setWebsiteHash($mResult['result']['website_hash']);
                        $oRemoteApp->save();
                    } else {
                        $this->get('logger')->error("Unknown error in ".__FILE__." on line ".__LINE__." - Result: ".json_encode($mResult), array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                        throw new \Exception("error in " . __FILE__ . " on line " . __LINE__);
                    }
                }
            } catch (\Exception $e) {
                $this->get('logger')->error($e->getMessage(), array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                $sResult['success'] = false;
                $sResult['message'] = $e->getMessage();
            }

            $response = new Response(json_encode($sResult));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }


        /**
         * Update monitoring module
         */
        public function updateApiAction($id)
        {

            return $this->initInstallCallAction($id);
        }


        /**
         * Get Error-Template
         *
         * @param $code
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function errorAction($code)
        {

            // catch non standard errors
            if (!in_array($code, array(
                400,
                401,
                403,
                404,
                444,
                500,
                501,
                502,
                503,
                504
            ))
            ) {
                $code = 0;
            }

            return $this->render('SlashworksAppBundle:Api:error.html.twig', array(
                'code' => $code
            ));
        }


        /**
         * run single api call for one remote app
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function runSingleApiCallAction($id)
        {


            $sLico = SystemSettings::get("lico");
            $iLvdc = SystemSettings::get("lvdc");

            if ($iLvdc < strtotime("-7 days")) {
                $aRemoteApps = RemoteAppQuery::create()->filterByWebsiteHash(null, \Criteria::ISNOTNULL);
                $lico        = $sLico . "/api/lvdc/" . base64_encode($this->_getSiteURL()) . "/" . $aRemoteApps->count();
                try {
                    $res = @file_get_contents($lico);
                    if ($res === false) {
                        throw new \Exception($this->get("translator")->trans("license.update.failed_lico"));
                    }
                    $oResult = json_decode($res);

                    if ($oResult->valid !== true) {
                        $aResponse = array(
                            "error"   => true,
                            "message" => $oResult->message
                        );
                    } else {
                        SystemSettings::set("lvdc", time());
                    }

                } catch (\Exception $e) {
                    $aResponse = array(
                        "error"   => true,
                        "message" => $e->getMessage()
                    );
                }
            }


            try {

                if (!isset($aResponse)) {
                    $command = new ApiCommand();
                    $command->setContainer($this->container);
                    $input  = new ArgvInput(array(
                                                'control:remote:cron',
                                                '--app=' . $id,
                                                '--force'
                                            ));


                    $output = new BufferedOutput();
                    // Run the command
                    $retval     = $command->run($input, $output);
                    $oRemoteApp = RemoteAppQuery::create()->findOneById($id);
                    $sJsonData  = $this->renderView('SlashworksAppBundle:RemoteApp:data.json.twig', array('entities' => array($oRemoteApp)));
                    $aData      = json_decode($sJsonData, true);

                    $sReturn = $output->fetch();
                    $aReturn = json_decode($sReturn, true);

                    if($aReturn !== false){
                        if(is_array($aReturn)){
                            if($aReturn['status'] === false) {
                                $this->get('logger')->error($aReturn['message'], array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                                $aResponse = $aReturn;
                            }elseif($aReturn['status'] === true) {
                                $this->get('logger')->info("Api-Call successful", array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName()));
                                $aResponse = $aData;
                            } else {
                                $this->get('logger')->error("Unknown error in ".__FILE__." on line ".__LINE__, array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                                $aResponse = array("error" => true);
                            }
                        }
                    }else {

                        if (!$retval) {
                            $this->get('logger')->info("Api-Call successful", array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName()));
                            $aResponse = $aData;
                        } else {
                            $this->get('logger')->error("Unknown error in ".__FILE__." on line ".__LINE__, array("Method" => __METHOD__, "RemoteApp" => $oRemoteApp->getName(), "RemoteURL" => $oRemoteApp->getFullApiUrl()));
                            $aResponse = array("error" => true);
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->get('logger')->error($e->getMessage());
                $aResponse = array(
                    "error"   => true,
                    "message" => $e->getMessage()
                );
            }

            $response = new Response(json_encode($aResponse));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }


        /**
         * Create new remote app
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function createAction(Request $request)
        {

            $oRemoteApp = new RemoteApp();
            $form       = $this->createCreateForm($oRemoteApp);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $sDomain = $oRemoteApp->getDomain();
                if(substr($sDomain,-1,1) !== "/"){
                    $sDomain .= "/";
                    $oRemoteApp->setDomain($sDomain);
                }

                $sModulePath = $oRemoteApp->getApiUrl();
                if(substr($sModulePath,0,1) === "/"){
                    $sModulePath = substr($sModulePath,1);
                    $oRemoteApp->setApiUrl($sModulePath);
                }

                $oRemoteApp->save();

                return $this->redirect($this->generateUrl('remote_app'));
            }

            return $this->render('SlashworksAppBundle:RemoteApp:new.html.twig', array(
                'entity' => $oRemoteApp,
                'form'   => $form->createView(),
            ));
        }


        /**
         * Displays a form to create a new RemoteApp entity.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function newAction()
        {

            $oRemoteApp = new RemoteApp();
            $oRemoteApp->setApiUrl("swControl/");
            $oRemoteApp->setActivated(true);
            $oRemoteApp->setIncludelog(true);
            $oRemoteApp->setNotificationRecipient($this->getUser()->getEmail());
            $oRemoteApp->setNotificationSender($this->getUser()->getEmail());
            $oRemoteApp->setNotificationChange(true);
            $oRemoteApp->setNotificationError(true);
            $form = $this->createCreateForm($oRemoteApp);

            return $this->render('SlashworksAppBundle:RemoteApp:new.html.twig', array(
                'entity' => $oRemoteApp,
                'form'   => $form->createView(),
            ));
        }


        /**
         * Displays a form to edit an existing RemoteApp entity.
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function editAction($id)
        {

            /** @var RemoteApp $oRemoteApp */
            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);

            if (count($oRemoteApp) === 0) {
                throw $this->createNotFoundException('Unable to find RemoteApp entity.');
            }

            $editForm   = $this->createEditForm($oRemoteApp);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('SlashworksAppBundle:RemoteApp:edit.html.twig', array(
                'entity'      => $oRemoteApp,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        /**
         * Update existing remote app
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param                                           $id
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function updateAction(Request $request, $id)
        {

            /** @var RemoteApp $oRemoteApp */
            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);

            if (count($oRemoteApp) === 0) {
                throw $this->createNotFoundException('Unable to find RemoteApp entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm   = $this->createEditForm($oRemoteApp);
            $editForm->handleRequest($request);


            if ($editForm->isValid()) {

                $sDomain = $oRemoteApp->getDomain();
                if(substr($sDomain,-1,1) !== "/"){
                    $sDomain .= "/";
                    $oRemoteApp->setDomain($sDomain);
                }
                $sModulePath = $oRemoteApp->getApiUrl();
                if(substr($sModulePath,0,1) === "/"){
                    $sModulePath = substr($sModulePath,1);
                    $oRemoteApp->setApiUrl($sModulePath);
                }

                $oRemoteApp->save();

                return $this->redirect($this->generateUrl('remote_app'));
            }

            return $this->render('SlashworksAppBundle:RemoteApp:edit.html.twig', array(
                'entity'      => $oRemoteApp,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        /**
         * Delete remote app
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param                                           $id
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         * @throws \Exception
         * @throws \PropelException
         */
        public function deleteAction(Request $request, $id)
        {

            /** @var RemoteApp $oRemoteApp */
            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);

            if ($oRemoteApp === null) {
                throw $this->createNotFoundException('Unable to find RemoteApp entity.');

            }

            // get history-entries for remoteapp to delete
            $aHistories = RemoteHistoryContaoQuery::create()->findByRemoteAppId($oRemoteApp->getId());
            foreach ($aHistories as $oHistory) {
                $oHistory->delete();
            }
            $oRemoteApp->delete();

            return $this->redirect($this->generateUrl('remote_app'));
        }


        /**
         * Shows last api-log entry
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function lastLogAction($id)
        {

            $oLog       = ApiLogQuery::create()->findOneByRemoteAppId($id);
            $oRemoteApp = RemoteAppQuery::create()->findOneById($id);

            return $this->render('SlashworksAppBundle:RemoteApp:log.html.twig', array(
                'oLog'       => $oLog,
                'remote_app' => $oRemoteApp,
            ));
        }


        /**
         * Creates a form to create a RemoteApp entity.
         *
         * @param RemoteApp $oRemoteApp The entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createCreateForm(RemoteApp $oRemoteApp)
        {

            $form = $this->createForm(new RemoteAppType(), $oRemoteApp, array(
                'action' => $this->generateUrl('remote_app_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Create'));

            return $form;
        }


        /**
         * @param \Slashworks\AppBundle\Model\RemoteApp $oRemoteApp
         *
         * @return \Symfony\Component\Form\Form
         */
        private function createEditForm(RemoteApp $oRemoteApp)
        {

            $form = $this->createForm(new RemoteAppType(), $oRemoteApp, array(
                'action' => $this->generateUrl('remote_app_update', array('id' => $oRemoteApp->getId())),
                'method' => 'PUT',
            ));

            $form->add('submit', 'submit', array('label' => 'Update'));

            return $form;
        }


        /**
         * Creates a form to delete a RemoteApp entity by id.
         *
         * @param mixed $id The entity id
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm($id)
        {

            return $this->createFormBuilder()->setAction($this->generateUrl('remote_app_delete', array('id' => $id)))->setMethod('DELETE')->add('submit', 'submit', array('label' => 'Delete'))->getForm();
        }
    }
