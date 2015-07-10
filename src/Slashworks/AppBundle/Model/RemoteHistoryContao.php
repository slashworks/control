<?php

namespace Slashworks\AppBundle\Model;

use Slashworks\AppBundle\Model\om\BaseRemoteHistoryContao;

/**
 * Class RemoteHistoryContao
 *
 * @package Slashworks\AppBundle\Model
 */
class RemoteHistoryContao extends BaseRemoteHistoryContao
{

    /**
     * @param $aData
     */
    public function setData($aData){
        if($aData['status'] !== false) {
            $this->setName($aData['name']);
            $this->setApiversion($aData['apiVersion']);
            $this->setVersion($aData['version']);
            $this->setPHP($aData['php']);
            $this->setMySQL($aData['mysql']);
            $this->setConfigDisplayerrors($aData['config']['displayErrors']);
            $this->setConfigBypasscache($aData['config']['bypassCache']);
            $this->setConfigMinifymarkup($aData['config']['minifyMarkup']);
            $this->setConfigDebugmode($aData['config']['debugMode']);
            $this->setConfigMaintenancemode($aData['config']['maintenanceMode']);
            $this->setConfigGzipscripts($aData['config']['gzipScripts']);
            $this->setConfigRewriteurl($aData['config']['rewriteURL']);
            $this->setConfigAdminemail($aData['config']['adminEmail']);
            $this->setConfigCachemode($aData['config']['cacheMode']);
            if(!is_array($aData['extensions'])){
                $aData['extensions'] = array();
            }
            $aExtensions = new \ArrayObject($aData['extensions']);
            if (isset($aData['log'])) {
                $aLogs = new \ArrayObject($aData['log']);
                $this->setLog($aLogs);
            }
            $this->setExtensions($aExtensions);
        }else{
            $aEmpty = new \ArrayObject(array());
            $this->setExtensions($aEmpty);
        }

        if(!isset($aData['statuscode'])){
            $aData['statuscode'] = -1;
        }
        $this->setStatuscode($aData['statuscode']);
    }

}
