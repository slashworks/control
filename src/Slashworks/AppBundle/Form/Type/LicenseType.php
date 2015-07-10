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
  * @since       10.07.2015 10:26
  * @package     Slashworks\AppBundle
  *
  */
namespace Slashworks\AppBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LicenseType
 *
 * @package Slashworks\AppBundle\Form\Type
 */
class LicenseType extends BaseAbstractType
{

    /**
     * @var array
     */
    protected $options = array(
        'data_class' => 'Slashworks\AppBundle\Model\License',
        'name'       => 'license',
        'language'   => 'en'
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('max_clients',null,array('read_only' => true));
        $builder->add('domain',null,array('read_only' => true));
        $builder->add('valid_until',null,array('read_only' => true));
        $builder->add('serial');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
                                   'data_class' => 'Slashworks\AppBundle\Model\License'
                               ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'slashworks_appbundle_license';
    }
}
