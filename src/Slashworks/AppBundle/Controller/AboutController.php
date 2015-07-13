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
     * Class AboutController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class AboutController extends AppController
    {

        /**
         * Display form for license activation
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function aboutAction()
        {


            $oLicense = LicenseQuery::create()->findOne();


            // include symfony requirements class
            require_once dirname(__FILE__) . '/../../../../app/SymfonyRequirements.php';
            $symfonyRequirements = new \SymfonyRequirements();

            // add additional requirement for mcrypt
            $symfonyRequirements->addRequirement(extension_loaded('mcrypt'), "Check if mcrypt ist loaded for RSA encryption", "Please enable mcrypt-Extension. See <a href='http://php.net/manual/de/mcrypt.setup.php'>http://php.net/manual/de/mcrypt.setup.php</a>");

            // fetch all data
            $aRequirements          = $symfonyRequirements->getRequirements();
            $aRecommendations       = $symfonyRequirements->getRecommendations();
            $aFailedRequirements    = $symfonyRequirements->getFailedRequirements();
            $aFailedRecommendations = $symfonyRequirements->getFailedRecommendations();
            $iniPath                = $symfonyRequirements->getPhpIniConfigPath();


            $sVersion  = file_get_contents(dirname(__FILE__) . '/../../../../version.txt');


            return $this->render('SlashworksAppBundle:About:about.html.twig', array(
                "license" => $oLicense,"version" => $sVersion, "iniPath" => $iniPath, "requirements" => $aRequirements, "recommendations" => $aRecommendations, "failedrequirements" => $aFailedRequirements, "failedrecommendations" => $aFailedRecommendations
            ));
        }



    }
