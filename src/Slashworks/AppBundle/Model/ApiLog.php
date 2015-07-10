<?php

namespace Slashworks\AppBundle\Model;

use Slashworks\AppBundle\Model\om\BaseApiLog;

/**
 * Class ApiLog
 *
 * @package Slashworks\AppBundle\Model
 */
class ApiLog extends BaseApiLog
{

    /**
     * @param $statuscode
     * @param $remote_app_id
     * @param $last_response
     *
     * @throws \Exception
     * @throws \PropelException
     */
    public static function create($statuscode,$remote_app_id, $last_response){

        $aLogs = ApiLogQuery::create()->findByRemoteAppId($remote_app_id);
        foreach($aLogs as $oLog){
            $oLog->delete();
        }

        $oApiLog = new ApiLog();
        $oApiLog->setRemoteAppId($remote_app_id);
        $oApiLog->setStatuscode($statuscode);
        $oApiLog->setLastResponse($last_response);
        $dt = new \DateTime();
        $oApiLog->setDtCall($dt);
        $oApiLog->save();
    }


    /**
     * @return string
     */
    public function getLastResponseAsString(){
        return stream_get_contents($this->getLastResponse());
    }
}
