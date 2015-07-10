<?php

    namespace Slashworks\BackendBundle\Twig;

    use Slashworks\BackendBundle\Model\SystemSettings;


    /**
     * Class SystemSettingsExtension
     *
     * @package Slashworks\BackendBundle\Twig
     */
    class SystemSettingsExtension extends \Twig_Extension{

//        public function getFilters()
//        {
//            return array(
//                new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
//            );
//        }

        /**
         * @return array
         */
        public function getFunctions(){
            return array(
                "system_settings" => new \Twig_Function_Method($this,"settings")
            );
        }


        /**
         * @param $key
         *
         * @return mixed
         */
        public function settings($key)
        {
            $sValue = SystemSettings::get($key);
            return $sValue;
        }


        /**
         * @return string
         */
        public function getName()
        {
            return 'system_settings_extension';
        }

    }