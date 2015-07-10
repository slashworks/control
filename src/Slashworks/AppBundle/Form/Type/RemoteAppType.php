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

/**
 * Class RemoteAppType
 *
 * @package Slashworks\AppBundle\Form\Type
 */
class RemoteAppType extends BaseAbstractType
{

    /**
     * @var array
     */
    protected $options = array(
        'data_class' => 'Slashworks\AppBundle\Model\RemoteApp',
        'name'       => 'remoteapp',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type');
        $builder->add('name');
        $builder->add('domain');
        $builder->add('apiUrl');
        $builder->add('apiAuthType','choice',array(
            "choices" => array(
                'none' => "remote_app.apiAuthType.none",
                'http-basic' => "remote_app.apiAuthType.http-basic",
                'url-user-password' => "remote_app.apiAuthType.url-user-password",
                'url-token' => "remote_app.apiAuthType.url-token"
            )
        ));
        $builder->add('apiAuthUser');
        $builder->add('apiAuthPassword');
        $builder->add('apiAuthHttpUser');
        $builder->add('apiAuthHttpPassword');
        $builder->add('apiAuthToken');
        $builder->add('notificationRecipient');
        $builder->add('notificationSender');
        $builder->add('notification_change',null, array("required" => false));
        $builder->add('notification_error',null, array("required" => false));
        $builder->add('notificationSender');
        $builder->add('apiAuthUrlUserKey');
        $builder->add('apiAuthUrlPwKey');
        $builder->add('cron');
        $builder->add('customer','model',array(
            'class'    => 'Slashworks\AppBundle\Model\Customer',
            'property' => 'name'
        ));
        $builder->add('activated',null, array("required" => false));
        $builder->add('notes');
        $builder->add('includeLog',null, array("required" => false));
    }
}
