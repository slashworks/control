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

    namespace Slashworks\BackendBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    /**
     * Class UserType
     *
     * @package Slashworks\BackendBundle\Form
     */
    class UserType extends AbstractType
    {

        /**
         * @param FormBuilderInterface $builder
         * @param array                $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {

            $builder
                ->add('username')
                ->add('firstname')
                ->add('lastname')
                ->add('email')
                ->add('phone')
                ->add('memo')
                ->add('activated', null, array("required" => false))
                ->add('password', 'password', array("required" => false, "mapped" => false,))
                ->add('password_repeat', 'password', array("mapped" => false, "required" => false))
                ->add('roles', 'model', array(
                    'class'    => 'Slashworks\BackendBundle\Model\Role',
                    'property' => 'role'
                ));
        }


        /**
         * @param OptionsResolverInterface $resolver
         */
        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {

            $resolver->setDefaults(array(
                                       'data_class' => 'Slashworks\BackendBundle\Model\User'
                                   ));
        }


        /**
         * @return string
         */
        public function getName()
        {

            return 'slashworks_backendbundle_user';
        }
    }
