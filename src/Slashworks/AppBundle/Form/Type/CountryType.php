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

/**
 * Class CountryType
 *
 * @package Slashworks\AppBundle\Form\Type
 */
class CountryType extends BaseAbstractType
{

    /**
     * @var array
     */
    protected $options = array(
        'data_class' => 'Slashworks\AppBundle\Model\Country',
        'name'       => 'country',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('en');
        $builder->add('de');
    }
}
