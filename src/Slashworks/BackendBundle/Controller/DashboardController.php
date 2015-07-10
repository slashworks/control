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
     * @package     Slashworks\BackendBundle
     *
     */

    namespace Slashworks\BackendBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class DashboardController
     *
     * @package Slashworks\BackendBundle\Controller
     */
    class DashboardController extends Controller
    {

        /**
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction()
        {

            return $this->render('SlashworksBackendBundle:Dashboard:index.html.twig', array());
        }

    }
