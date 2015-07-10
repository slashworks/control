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
     * @since       23.01.15 07:38
     * @package     Slashworks\AppBundle
     *
     */

    namespace Slashworks\AppBundle\Controller;

    use Slashworks\AppBundle\Model\UserCustomerRelationQuery;
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * Class AppController
     *
     * @package Slashworks\AppBundle\Controller
     */
    class AppController extends Controller
    {



        /**
         * Get current Control URl
         *
         * @return string
         */
        public function _getSiteURL()
        {

            $sUrl = SystemSettings::get("control_url");

            return $sUrl;
        }


        /**
         * Check if user has access to customer
         *
         * @param int $iCustomerId
         *
         * @return bool
         */
        public function check4Client($iCustomerId)
        {

            if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
                return true;
            } else {
                $oUser = $this->getUser();
                if (empty($oUser)) {
                    return false;
                }

                $oResult = UserCustomerRelationQuery::create()->findOneByArray(array("UserId" => $oUser->getId(), "CustomerId" => $iCustomerId));

                return (!empty($oResult));
            }

        }
    }