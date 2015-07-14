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

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\SecurityContext;

    /**
     * Class SecurityController
     *
     * @package Slashworks\BackendBundle\Controller
     */
    class SecurityController extends BackendController
    {

        /**
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function loginAction(Request $request)
        {

            if ($this->container->getParameter('database_password') === null) {
                return $this->redirect($this->generateUrl('install_license'));
            } else {
                $request = $this->getRequest();
                $session = $request->getSession();

                // get the login error if there is one
                if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                    $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
                } else {
                    $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                }


                return $this->render('SlashworksBackendBundle:Security:login.html.twig', array(
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error'         => $error,
                ));
            }
        }
    }
