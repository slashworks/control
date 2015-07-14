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
     * @since       10.07.2015 10:04
     * @package     Slashworks\AppBundle
     *
     */

    namespace Slashworks\AppBundle\Controller;

    use Slashworks\AppBundle\Form\Type\LicenseType;
    use Slashworks\AppBundle\Model\License;
    use Slashworks\AppBundle\Model\LicenseQuery;
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class LicenseController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class LicenseController extends AppController
    {

        /**
         * Display form for license activation
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function activateLicenseAction()
        {

            $oLicense = LicenseQuery::create()->findOne();

            return $this->render('SlashworksAppBundle:License:edit_license.html.twig', array(
                "license" => $oLicense
            ));
        }


        /**
         * Displays a form to edit an existing RemoteApp entity.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function editAction()
        {

            /** @var License $oLicense */
            $oLicense = LicenseQuery::create()->findOne();

            if ($oLicense === null) {
                throw $this->createNotFoundException('Unable to find License entity.');
            }

            $oLicense->setValidUntil(date("d.m.Y", $oLicense->getValidUntil()));
            $editForm = $this->createEditForm($oLicense);

            return $this->render('SlashworksAppBundle:License:edit_license.html.twig', array(
                'entity'    => $oLicense,
                'edit_form' => $editForm->createView(),
            ));
        }


        /**
         * Update license
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function updateAction(Request $request)
        {

            /** @var License $oLicense */
            $oLicense = LicenseQuery::create()->findOne();

            if ($oLicense === null) {
                throw $this->createNotFoundException('Unable to find License entity.');
            }

            $editForm = $this->createEditForm($oLicense);
            $editForm->handleRequest($request);

            $aResult = array(
                "success" => false,
                "message" => ""
            );

            $sLico = SystemSettings::get("lico");

            $aHeaders = array(
                'Content-Type: application/json'
            );

            $sDomain = $this->_getSiteURL();

            $aRequest = array(
                'lico' => array(
                    'domain'  => $sDomain,
                    'license' => $oLicense->getSerial()
                ),
            );

            $sRequest = json_encode($aRequest);

            /*
             * Check license against license-server
             */
            $oRequest = curl_init($sLico . "/api/check/license");
            curl_setopt($oRequest, CURLOPT_HTTPHEADER, $aHeaders);
            curl_setopt($oRequest, CURLOPT_TIMEOUT, 120);
            curl_setopt($oRequest, CURLOPT_POST, 1);
            curl_setopt($oRequest, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oRequest, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oRequest, CURLOPT_POSTFIELDS, $sRequest);
            curl_setopt($oRequest, CURLOPT_RETURNTRANSFER, true);
            $response    = curl_exec($oRequest);
            $iHttpStatus = curl_getinfo($oRequest, CURLINFO_HTTP_CODE);
            $error       = curl_error($oRequest);
            curl_close($oRequest);

            if ($iHttpStatus == 200) {

                $oResponse = json_decode($response);

                if ($editForm->isValid() && $oResponse->valid == true) {
                    $aResult['max_clients'] = $oResponse->max_clients;
                    $aResult['valid_until'] = $oResponse->valid_until;
                    $aResult['domain']      = $sDomain;

                    $aResult['success'] = true;
                    $aResult['message'] = $this->get("translator")->trans("license.update.successful");

                    // license valid, save new license-data
                    $oLicense->setValidUntil($aResult['valid_until']);
                    $oLicense->setMaxClients($aResult['max_clients']);
                    $oLicense->setDomain($sDomain);
                    $oLicense->save();
                } else {
                    $aResult['success'] = false;
                    $aResult['message'] = $this->get("translator")->trans("license.update.failed");
                    $aResult['valid_until'] = strtotime("1970-01-01");
                    $aResult['max_clients'] = 0;
                    $aResult['domain'] = "-";
                }


            } else {

                $aResult['max_clients'] = $oLicense->getMaxClients();
                $aResult['valid_until'] = strtotime($oLicense->getValidUntil());
                $aResult['domain']      = $sDomain;

                $aResult['success'] = false;
                $aResult['message'] = $this->get("translator")->trans("license.update.failed_lico");
            }


            $sResult  = json_encode($aResult);
            $response = new Response($sResult);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }


        /**
         * Create edit form for lucense
         *
         * @param \Slashworks\AppBundle\Model\License $oLicense
         *
         * @return \Symfony\Component\Form\Form
         */
        private function createEditForm(License $oLicense)
        {

            $oForm = $this->createForm(new LicenseType(), $oLicense, array(
                'action' => $this->generateUrl('license_update', array('id' => $oLicense->getId())),
                'method' => 'PUT',
            ));

            $oForm->add('submit', 'submit', array('label' => 'Update'));

            return $oForm;
        }

    }
