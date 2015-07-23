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
     * @since       10.07.2015 08:58
     * @package     SlashworksBackendBundle
     *
     */
    namespace Slashworks\BackendBundle\Controller;

    use Slashworks\BackendBundle\Form\Type\InstallType;
    use Slashworks\BackendBundle\Helper\InstallHelper;
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Class InstallController
     *
     * @package Slashworks\BackendBundle\Controller
     */
    class InstallController extends Controller
    {


        /**
         * Check System Requirements
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function requirementsAction()
        {

            // include symfony requirements class
            $sAppPath = $this->getParameter('kernel.root_dir');
            require_once $sAppPath.'/SymfonyRequirements.php';
            $symfonyRequirements = new \SymfonyRequirements();

            // add additional requirement for mcrypt
            $symfonyRequirements->addRequirement(extension_loaded('mcrypt'), "Check if mcrypt ist loaded for RSA encryption", "Please enable mcrypt-Extension. See <a href='http://php.net/manual/de/mcrypt.setup.php'>http://php.net/manual/de/mcrypt.setup.php</a>");

            // fetch all data
            $aRequirements          = $symfonyRequirements->getRequirements();
            $aRecommendations       = $symfonyRequirements->getRecommendations();
            $aFailedRequirements    = $symfonyRequirements->getFailedRequirements();
            $aFailedRecommendations = $symfonyRequirements->getFailedRecommendations();
            $iniPath                = $symfonyRequirements->getPhpIniConfigPath();

            // render template
            return $this->render('SlashworksBackendBundle:Install:requirements.html.twig', array("iniPath" => $iniPath, "requirements" => $aRequirements, "recommendations" => $aRecommendations, "failedrequirements" => $aFailedRequirements, "failedrecommendations" => $aFailedRecommendations));
        }

        /**
         * Check System Requirements
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function licenseAction()
        {

            // render template
            return $this->render('SlashworksBackendBundle:Install:license.html.twig', array());
        }


        /**
         * Check System Requirements
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function licenseAgreeAction()
        {


            // render template
            return $this->render('SlashworksBackendBundle:Install:license.html.twig', array());
        }

        /**
         * Display install form
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function installAction()
        {

            // create install form
            $form = $this->createForm(new InstallType(), null, array('action' => $this->generateUrl('install_process')));

            // redirect to login if config already filled
            if ($this->container->getParameter('database_password') !== null) {
                return $this->redirect($this->generateUrl('login'));
            } else {
                return $this->render('SlashworksBackendBundle:Install:install.html.twig', array("error" => false, "errorMessage" => false, "form" => $form->createView()));
            }
        }


        /**
         * Process provided informations and perform installation
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function processInstallAction(Request $request)
        {

            // include symfony requirements class
            require_once dirname(__FILE__) . '/../../../../app/SymfonyRequirements.php';

            // prevent from being called directly after install...
            if ($this->container->getParameter('database_password') !== null) {
                return $this->redirect($this->generateUrl('login'));
            }

            // get form type for validation
            $form = $this->createForm(new InstallType(), null, array('action' => $this->generateUrl('install_process')));
            $form->handleRequest($request);

            if ($form->isValid()) {

                try {
                    // get data and do install
                    $aData = $request->request->all();
                    InstallHelper::doInstall($this->container, $aData);

                    // goto login if successful
                    return $this->redirect($this->generateUrl('login'));
                } catch (\Exception $e) {
                    return $this->render('SlashworksBackendBundle:Install:install.html.twig', array("form" => $form->createView(), "error" => true, "errorMessage" => $e->getMessage()));
                }
            } else {
                return $this->render('SlashworksBackendBundle:Install:install.html.twig', array("form" => $form->createView(), "error" => true, "errorMessage" => false));
            }
        }
    }
