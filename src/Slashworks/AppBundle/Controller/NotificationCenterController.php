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
     * @since       10.07.2015 10:09
     * @package     Slashworks\AppBundle
     *
     */
    namespace Slashworks\AppBundle\Controller;

    use Slashworks\BackendBundle\Model\UserQuery;
    use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class NotificationCenterController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class NotificationCenterController extends AppController
    {

        /**
         * Display form for notification settings
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction()
        {

            $id = $this->getUser()->getId();

            /** @var User $oUser */
            $oUser = UserQuery::create()->findOneById($id);

            $form = $this->createFormBuilder($oUser)
                ->setAction($this->generateUrl("notification_center_update"))
                ->add('notification_change', 'checkbox')
                ->add('notification_error', 'checkbox')
                ->add('save', 'submit', array('label' => $this->get('translator')->trans('notificationcenter.form.save')))
                ->getForm();


            return $this->render('SlashworksAppBundle:NotificationCenter:index.html.twig', array(
                'user' => $oUser,
                'form' => $form->createView()
            ));
        }


        /**
         * Update notification settings
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function updateAction(Request $request)
        {

            try {
                $id = $this->getUser()->getId();

                /** @var User $oUser */
                $oUser = UserQuery::create()->findOneById($id);

                if ($oUser === null) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }

                $aPost = $request->request->get("form");


                $nbUpdatedRows = UserQuery::create()
                    ->filterById($id)
                    ->update(array('NotificationError' => isset($aPost['notification_error']), 'NotificationChange' => isset($aPost['notification_change'])));


                $aResult = array(
                    "success" => true,
                    "message" => $this->get("translator")->trans("notificationcenter.save.successful")
                );

            } catch (\Exception $e) {
                $aResult = array(
                    "success" => false,
                    "message" => $this->get("translator")->trans("notificationcenter.save.failed") . ":<br>" . $e->getMessage()
                );
            }

            $sResult  = json_encode($aResult);
            $response = new Response($sResult);
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }

    }
