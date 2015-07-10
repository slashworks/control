<?php

namespace Slashworks\BackendBundle\Model;

use Slashworks\BackendBundle\Model\om\BaseUser;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends BaseUser implements UserInterface
{

    /**
     * @return array
     */
    public function getRoles()
    {
        $aRoles = array();

        foreach($this->getUserRolesJoinRole() as $t) {
            $aRoles[] = $t->getRole()->getRole();
        }

       return $aRoles;
    }


    public function getRole(){
        foreach($this->getUserRolesJoinRole() as $t) {
            $aRoles[] = $t->getRole();
        }

        return $aRoles[0];
    }


    /**
     * @param $oRole
     */
    public function setRoles($oRole){

        $oUserRoles = new UserRole();
        $oUserRoles->setRole($oRole);
        $oUserRoles->setUser($this);
        $aCollection = new \PropelCollection();
        $aCollection->append($oUserRoles);

        $this->setUserRoles($aCollection);
    }

    public function getSalt(){
        if(empty($this->salt)){
            $this->setSalt(md5(uniqid(null, true)));
        }
        return $this->salt;
    }


    public function checkNotificationSetting($sValue){
        if(!method_exists($this,"get".ucfirst($sValue))){
            throw new \Exception("Notificationsettings for ".$sValue." not found");
        }

        return $this->{"get".ucfirst($sValue)}();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPassword(null);
        $this->setSalt(null);
    }

}
