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
    namespace Slashworks\AppBundle\Model;

    use Slashworks\AppBundle\Model\om\BaseRemoteApp;

    /**
     * Class RemoteApp
     *
     * @package Slashworks\AppBundle\Model
     */
    class RemoteApp extends BaseRemoteApp
    {


        public function checkNotificationSetting($sValue){
            if(!method_exists($this,"get".ucfirst($sValue))){
                throw new \Exception("Notificationsettings for "."get".ucfirst($sValue)." not found");
            }

            return $this->{"get".ucfirst($sValue)}();
        }

        /**
         * @return string
         */
        public function generateFileName(){
            $sName = $this->getName();
            $sName = strtolower($sName);
            $arrSearch = array('/[^a-zA-Z0-9 \.\&\/_-]+/', '/[ \.\&\/-]+/');
            $arrReplace = array('', '-');
            $sName = preg_replace($arrSearch, $arrReplace, $sName);

            return trim($sName, '-');
        }

        /**
         * @return string
         */
        public function getUpdateUrl(){
            $sUrl = $this->getDomain().$this->getApiUrl()."public/update.php";
            return $sUrl;
        }


        /**
         * @return string
         */
        public function getFullApiUrl(){
            $sUrl = $this->getDomain().$this->getApiUrl()."server/public/api.php";
            return $sUrl;
        }


        public function saveApiCallResult($aResult){

        }

        public function getRemoteHistoryContao(){
            $aReturn = parent::getRemoteHistoryContaos();
            if($aReturn instanceof \PropelCollection) {
                if($aReturn->count() > 0) {
                    return $aReturn[0];
                }
            }
            $o = new RemoteHistoryContao();
            $a = new \ArrayObject(array());
            $o->setExtensions($a);
            return $o;
        }


        public function getRemoteHistoryContaoAsArray(){
            $oReturn = $this->getRemoteHistoryContao();
            if($oReturn === false){
                return json_encode(array());
            }
            $aReturn               = $oReturn->toArray();
            $aReturn['Extensions'] = $aReturn['Extensions']->getArrayCopy();

            $sMaintenance = $aReturn['ConfigMaintenancemode'];
            $aReturn['ConfigMaintenancemode'] = "<span id=\"maintenanceMode_".$this->getId()."\">";
            if($sMaintenance === 'On') {
                $aReturn['ConfigMaintenancemode'] .= "<i class=\"fa fa-warning\" style=\"color:#F2963F\"></i>";
            }else{
                $aReturn['ConfigMaintenancemode'] .= "<i class=\"fa fa-warning\" style=\"color:#ccc\"></i>";
            }

            $aReturn['ConfigMaintenancemode'] .= "</span>";

            return $aReturn;
        }


        public function getRemoteHistoryContaoAsJson(){
            $aReturn = $this->getRemoteHistoryContaoAsArray();
            return json_encode($aReturn);
        }

    }
