<?php

namespace Slashworks\BackendBundle\Model;

use Slashworks\BackendBundle\Model\om\BaseSystemSettings;

/**
 * Class SystemSettings
 *
 * @package Slashworks\BackendBundle\Model
 */
class SystemSettings extends BaseSystemSettings
{

    /**
     * @param $key
     *
     * @return mixed
     */
    public static function get($key){
        return SystemSettingsQuery::create()->findOneBy("key",$key)->getValue();
    }


    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     * @throws \Exception
     * @throws \PropelException
     */
    public static function set($key, $value){
        $oSystemSetting = SystemSettingsQuery::create()->findOneBy("key",$key);
        $oSystemSetting->setKey($key);
        $oSystemSetting->setValue($value);
        $oSystemSetting->save();
        return $value;
    }
}
