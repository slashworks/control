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

    use Slashworks\AppBundle\Form\Type\CustomerType;
    use Slashworks\AppBundle\Model\Customer;
    use Slashworks\AppBundle\Model\CustomerQuery;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use Symfony\Component\HttpFoundation\FileBag;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Class CustomerController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class CustomerController extends AppController
    {

        /**
         * @return string
         */
        public function getParent()
        {

            return 'SlashworksBackendBundle';
        }


        /**
         * Lists all Customer entities.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction()
        {

            $aCustomers = CustomerQuery::create()->find();

            return $this->render('SlashworksAppBundle:Customer:index.html.twig', array(
                'entities' => $aCustomers,
            ));
        }


        /**
         * Create new customer
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Exception
         * @throws \PropelException
         */
        public function createAction(Request $request)
        {

            $oCustomer = new Customer();
            // create customerform for validation
            $oForm = $this->createCreateForm($oCustomer);
            $oForm->handleRequest($request);
            if ($oForm->isValid()) {

                // handle logoupload if present
                $sLogoPath = $this->_handleLogoUpload($request, $oCustomer);
                $oCustomer->setLogo($sLogoPath);
                // save logo to customer
                $oCustomer->save();

                // redirect to customerlist if successful
                return $this->redirect($this->generateUrl('backend_system_customer'));
            }

            // if error occured, redirect back to form
            return $this->render('SlashworksAppBundle:Customer:new.html.twig', array(
                'entity' => $oCustomer,
                'form'   => $oForm->createView(),
            ));
        }


        /**
         * Modal info window for customerinformations
         *
         * @param int $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function modalInfoAction($id)
        {

            /** @var Customer $oCustomer */
            $oCustomer = CustomerQuery::create()->findOneById($id);

            return $this->render('SlashworksAppBundle:Customer:modal_info.html.twig', array(
                'customer' => $oCustomer
            ));

        }


        /**
         * Displays a form to create a new Customer entity.
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function newAction()
        {

            $oCustomer = new Customer();
            $form      = $this->createCreateForm($oCustomer);

            return $this->render('SlashworksAppBundle:Customer:new.html.twig', array(
                'entity' => $oCustomer,
                'form'   => $form->createView(),
            ));
        }


        /**
         * Displays a form to edit an existing Customer entity.
         *
         * @param int $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function editAction($id)
        {

            /** @var Customer $oCustomer */
            $oCustomer = CustomerQuery::create()->findOneById($id);

            if (count($oCustomer) === 0) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $oEditForm   = $this->createEditForm($oCustomer);
            $oDeleteForm = $this->createDeleteForm($id);

            return $this->render('SlashworksAppBundle:Customer:edit.html.twig', array(
                'entity'      => $oCustomer,
                'edit_form'   => $oEditForm->createView(),
                'delete_form' => $oDeleteForm->createView(),
            ));
        }


        /**
         * Update existing customer
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param  int                                      $id
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function updateAction(Request $request, $id)
        {

            /** @var Customer $oCustomer */
            $oCustomer = CustomerQuery::create()->findOneById($id);

            if (count($oCustomer) === 0) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm   = $this->createEditForm($oCustomer);
            $editForm->handleRequest($request);


            if ($editForm->isValid()) {


                $sLogoPath = $this->_handleLogoUpload($request, $oCustomer);
                $oCustomer->setLogo($sLogoPath);

                $oCustomer->save();

                return $this->redirect($this->generateUrl('backend_system_customer'));
            }

            return $this->render('SlashworksAppBundle:Customer:edit.html.twig', array(
                'entity'      => $oCustomer,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        /**
         * Delete customer
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param                                           $id
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         */
        public function deleteAction(Request $request, $id)
        {

            /** @var Customer $oCustomer */
            $oCustomer = CustomerQuery::create()->findOneById($id);

            if ($oCustomer === null) {
                throw $this->createNotFoundException('Unable to find Customer entity.');

            }
            $oCustomer->delete();

            return $this->redirect($this->generateUrl('backend_system_customer'));
        }


        /**
         * Handle Logo uplaod
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param \Slashworks\AppBundle\Model\Customer      $oCustomer
         *
         * @return string
         */
        private function _handleLogoUpload(Request &$request, Customer &$oCustomer)
        {

            $sLogoPath = "";

            /** @var FileBag $t */
            $oFiles      = $request->files;
            $aFiles      = $oFiles->get("slashworks_appbundle_customer");
            $sUploadPath = __DIR__ . "/../../../../web/files/customers";

            if (isset($aFiles['logo'])) {
                if (!empty($aFiles['logo'])) {
                    /** @var UploadedFile $oUploadedFile */
                    $oUploadedFile = $aFiles['logo'];

                    $sUniqId   = sha1(uniqid(mt_rand(), true));
                    $sFileName = $sUniqId . '.' . $oUploadedFile->guessExtension();

                    $oUploadedFile->move($sUploadPath, $sFileName);
                    $sLogoPath = $sFileName;
                }
            }


            return $sLogoPath;
        }


        /**
         * Creates a form to create a Customer entity.
         *
         * @param Customer $oCustomer The entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createCreateForm(Customer $oCustomer)
        {

            $form = $this->createForm(new CustomerType(array("language" => $this->get('request')->getLocale())), $oCustomer, array(
                'action' => $this->generateUrl('backend_system_customer_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Create'));

            return $form;
        }


        /**
         * Create form for editing customer
         *
         * @param \Slashworks\AppBundle\Model\Customer $oCustomer
         *
         * @return \Symfony\Component\Form\Form
         */
        private function createEditForm(Customer $oCustomer)
        {

            $oForm = $this->createForm(new CustomerType(array("language" => $this->get('request')->getLocale())), $oCustomer, array(
                'action' => $this->generateUrl('backend_system_customer_update', array('id' => $oCustomer->getId())),
                'method' => 'PUT',
            ));

            $oForm->add('submit', 'submit', array('label' => 'Update'));

            return $oForm;
        }


        /**
         * Creates a form to delete a Customer entity by id.
         *
         * @param mixed $id The entity id
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm($id)
        {

            return $this->createFormBuilder()
                ->setAction($this->generateUrl('backend_system_customer_delete', array('id' => $id)))
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label' => 'Delete'))
                ->getForm();
        }
    }
