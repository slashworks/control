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
      * @since       10.07.2015 10:25
      * @package     Slashworks\AppBundle
      *
      */

namespace Slashworks\AppBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CustomerType
 *
 * @package Slashworks\AppBundle\Form\Type
 */
class CustomerType extends BaseAbstractType
{

    /**
     * @var array
     */
    protected $options = array(
        'data_class' => 'Slashworks\AppBundle\Model\Customer',
        'name'       => 'customer',
        'language'   => 'en'
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name');
        $builder->add('street');
        $builder->add('zip');
        $builder->add('city');
        $builder->add('country', 'model', array(
            'class'    => 'Slashworks\AppBundle\Model\Country',
            'property' => $this->getOption("language")
        ));
        $builder->add('phone');
        $builder->add('fax');
        $builder->add('email');
        $builder->add('legalform');
        $builder->add('logo','file',array('data_class'=>null,'required' => false));
        $builder->add('created');
        $builder->add('notes');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
                                   'data_class' => 'Slashworks\AppBundle\Model\Customer'
                               ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'slashworks_appbundle_customer';
    }
}
