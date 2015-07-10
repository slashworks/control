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

    use Slashworks\BackendBundle\Model\UserRoleQuery;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Slashworks\BackendBundle\Model\User;
    use Slashworks\BackendBundle\Model\UserQuery;
    use Slashworks\BackendBundle\Form\UserType;


    /**
     * Class UserController
     *
     * @package Slashworks\BackendBundle\Controller
     */
    class UserController extends Controller
    {

        /**
         * Lists all User entities.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction()
        {

            $aUsers = UserQuery::create()->find();

            return $this->render('SlashworksBackendBundle:User:index.html.twig', array(
                'entities' => $aUsers,
            ));
        }

        /**
         * Creates a new User entity.
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function createAction(Request $request)
        {
            $oUser = new User();
            $form = $this->createCreateForm($oUser);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $factory  = $this->get('security.encoder_factory');
                $encoder  = $factory->getEncoder($oUser);
                $password = $encoder->encodePassword($oUser->getPassword(), $oUser->getSalt());
                $oUser->setPassword($password);
                $oUser->save();

                return $this->redirect($this->generateUrl('backend_system_user'));
            }

            return $this->render('SlashworksBackendBundle:User:new.html.twig', array(
                'entity' => $oUser,
                'form'   => $form->createView(),
            ));
        }


        /**
         * Displays a form to create a new User entity.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function newAction()
        {
            $oUser = new User();
            $form   = $this->createCreateForm($oUser);

            return $this->render('SlashworksBackendBundle:User:new.html.twig', array(
                'entity' => $oUser,
                'form'   => $form->createView(),
            ));
        }


        /**
         * Displays a form to edit an existing User entity.
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function editAction($id)
        {
            /** @var User $oUser */
            $oUser = UserQuery::create()->findOneById($id);

            if (count($oUser) === 0) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $editForm = $this->createEditForm($oUser);
            $deleteForm = $this->createDeleteForm($id);

            // preselect Role
            $editForm->get('roles')->setData($oUser->getRole());

            return $this->render('SlashworksBackendBundle:User:edit.html.twig', array(
                'entity'      => $oUser,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        /**
         * Edits an existing User entity.
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param                                           $id
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function updateAction(Request $request, $id)
        {

            /** @var User $oUser */
            $oUser = UserQuery::create()->findOneById($id);

            if (count($oUser) === 0) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($oUser);
            $editForm->handleRequest($request);

            $aUserRoles = UserRoleQuery::create()->findByUserId($oUser->getId());

            if ($editForm->isValid()) {


                foreach($aUserRoles as $oUserRole){
                    $oUserRole->setUserId($oUser->getId());
                    $oUserRole->delete();
                }
                $aFormData =$request->request->get('slashworks_backendbundle_user');
                $sPassword = $aFormData['password'];
                $sPasswordRepeat = $aFormData['password_repeat'];
                if(!empty($sPassword) && !empty($sPasswordRepeat)){
                    if($sPassword === $sPasswordRepeat){
                        $factory  = $this->get('security.encoder_factory');
                        $encoder  = $factory->getEncoder($oUser);
                        $sPassword = $encoder->encodePassword($sPassword, $oUser->getSalt());
                        $oUser->setPassword($sPassword);
                    }else{

                    }
                }elseif(!empty($sPassword) && empty($sPasswordReqpeat)){

                }

                $oUser->save();

                return $this->redirect($this->generateUrl('backend_system_user'));
            }

            return $this->render('SlashworksBackendBundle:User:edit.html.twig', array(
                'entity'      => $oUser,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        /**
         * Deletes a User entity.
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
            /** @var User $oUser */
            $oUser = UserQuery::create()->findOneById($id);

            if (count($oUser) === 0) {
                throw $this->createNotFoundException('Unable to find User entity.');

            }
            $oUser->delete();

            return $this->redirect($this->generateUrl('backend_system_user'));
        }


        /**
         * Creates a form to create a User entity.
         *
         * @param User $oUser The entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createCreateForm(User $oUser)
        {
            $form = $this->createForm(new UserType(), $oUser, array(
                'action' => $this->generateUrl('backend_system_user_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Create'));

            return $form;
        }


        /**
        * Creates a form to edit a User entity.
        *
        * @param User $entity The entity
        *
        * @return \Symfony\Component\Form\Form The form
        */
        private function createEditForm(User $oUser)
        {
            $form = $this->createForm(new UserType(), $oUser, array(
                'action' => $this->generateUrl('backend_system_user_update', array('id' => $oUser->getId())),
                'method' => 'PUT',
            ));

            $form->add('submit', 'submit', array('label' => 'Update'));

            return $form;
        }


        /**
         * Creates a form to delete a User entity by id.
         *
         * @param mixed $id The entity id
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm($id)
        {
            return $this->createFormBuilder()
                ->setAction($this->generateUrl('backend_system_user_delete', array('id' => $id)))
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label' => 'Delete'))
                ->getForm()
            ;
        }
    }
