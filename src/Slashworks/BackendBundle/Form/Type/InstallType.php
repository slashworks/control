<?php

    namespace Slashworks\BackendBundle\Form\Type;

    use Propel\PropelBundle\Form\BaseAbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Validator\Constraints\Length;
    use Symfony\Component\Validator\Constraints\NotBlank;

    /**
     * Class InstallType
     *
     * @package Slashworks\AppBundle\Form\Type
     */
    class InstallType extends BaseAbstractType
    {


        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {

            $resolver->setDefaults(array(
                                       'csrf_protection' => true,
                                       'csrf_field_name' => '_token',
                                       // a unique key to help generate the secret token
                                       'intention'       => 'install_form_intention',
                                   ));
        }


        private function _getSiteURL()
        {
            $protocol   = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'];

            return $protocol . $domainName;
        }

        /**
         * {@inheritdoc}
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {


            $builder
                ->add("controlUrl", "text", array(
                                      'required'    => true,
                                      'data'        => $this->_getSiteURL(),
                                      'constraints' => array(
                                          new NotBlank(),
                                          new Length(array('min' => 3)),
                                      )
                                  )
                )
                ->add("adminUser", "text", array(
                                         'required'    => true,
                                         'data'        => 'admin',
                                         'constraints' => array(
                                             new NotBlank(),
                                             new Length(array('min' => 3)),
                                         )
                                     )
            )
                ->add("adminEmail", "text", array(
                                     'required'    => true,
                                     'data'        => '',
                                     'constraints' => array(
                                         new NotBlank(),
                                         new Length(array('min' => 3)),
                                     )
                                 )
                )
                ->add('adminPassword', 'password', array(
                                         'required'    => true,
                                         'constraints' => array(
                                             new NotBlank(),
                                             new Length(array('min' => 3)),
                                         )
                                     )
                )
                ->add('dbDriver', 'choice', array(
                                    'choices'     => array(
                                        'pdo_mysql'  => 'MySQL (PDO)',
//                                        'pdo_sqlite' => 'SQLite (PDO)',
                                        'pdo_pgsql'  => 'PosgreSQL (PDO)',
//                                        'oci8'       => 'Oracle (native)',
//                                        'ibm_db2'    => 'IBM DB2 (native)',
//                                        'pdo_oci'    => 'Oracle (PDO)',
//                                        'pdo_ibm'    => 'IBM DB2 (PDO)',
//                                        'pdo_sqlsrv' => 'SQLServer (PDO)',
                                    ),
                                    'required'    => true, 'data' => 'MySQLi',
                                    'constraints' => array(
                                        new NotBlank(),
                                    )
                                )
                )
                ->add('dbHost', 'text', array(
                                  'required'    => true,
                                  'data'        => 'localhost',
                                  'constraints' => array(
                                      new NotBlank(),
                                      new Length(array('min' => 3)),
                                  )
                              )
                )
                ->add('dbName', 'text', array(
                                  'required'    => true,
                                  'data'        => '',
                                  'constraints' => array(
                                      new NotBlank(),
                                      new Length(array('min' => 3)),
                                  )
                              )
                )
                ->add('dbUser', 'text', array(
                                  'required'    => true,
                                  'data'        => '',
                                  'constraints' => array(
                                      new NotBlank(),
                                      new Length(array('min' => 3)),
                                  )
                              )
                )
                ->add('dbPassword', 'password', array(
                                      'required'    => true,
                                      'data'        => '',
                                      'constraints' => array(
                                          new NotBlank(),
                                          new Length(array('min' => 3)),
                                      )
                                  )
                )
                ->add('dbPort', 'text', array(
                                  'required'    => true,
                                  'data'        => 3306,
                                  'constraints' => array(
                                      new NotBlank(),
                                      new Length(array('min' => 4)),
                                  )
                              )
                )
                ->add('mailerTransport', 'choice', array(
                                           'choices'     => array('smtp'=>'smtp', 'mail'=> 'mail', 'sendmail'=>'sendmail'),
                                           'required'    => true,
                                           'data'        => 'smtp',
                                           'constraints' => array(
                                               new NotBlank(),
                                           )
                                       )
                )
                ->add('mailerHost', 'text', array('required' => false, 'data' => 'localhost'))
                ->add('mailerUser', 'text', array('required' => false))
                ->add('mailerPassword', 'password', array('required' => false));
        }


        /**
         * @return string
         */
        public function getName()
        {

            return 'slashworks_backendbundle_install';
        }




    }



