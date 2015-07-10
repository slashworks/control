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
     * @since       10.07.15 09:22
     * @package     Core
     *
     */

    namespace Slashworks\AppBundle\Command;

    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

    class SlashworksCommand extends ContainerAwareCommand
    {


        /**
         *  configure cli command for listing remoteapps
         */
        protected function configure()
        {

            $appName = SystemSettings::get("app_name");

            $this->setName($appName);
        }


        /**
         * Get current Control URl
         *
         * @return string
         */
        protected function _getSiteURL()
        {

            $sUrl = SystemSettings::get("control_url");

            return $sUrl;
        }


        /**
         * Slashwors Logo in colored ASCII-Art :)
         *
         * @param $output
         */
        protected function _printLogo(&$output)
        {

            $output->writeLn('');
            $output->writeLn('');
            $output->writeLn('');
            $output->writeLn('<sw>          _           _                       _           </sw>');
            $output->writeLn('<sw>         | |         | |                     | |          </sw>');
            $output->writeLn('<sw>      ___| | __ _ ___| |____      _____  _ __| | _____    </sw>');
            $output->writeLn('<sw>     / __| |/ _` / __| \'_ \ \ /\ / / _ \| \'__| |/ / __|   </sw>');
            $output->writeLn('<sw>     \__ \ | (_| \__ \ | | \ V  V / (_) | |  |   <\__ \   </sw>');
            $output->writeLn('<sw>     |___/_|\__,_|___/_| |_|\_/\_/ \___/|_|  |_|\_\___/   </sw>');
            $output->writeLn('<fg=white>                                        web development   </fg=white>');
            $output->writeLn('');
            $output->writeLn('');
            $output->writeLn('                    [ <info>Cronjob Manager</info> ]');
            $output->writeLn('');
            $output->writeLn('');


        }


        /**
         * Compare 2 arrays recursive
         *
         * @param $aArray1
         * @param $aArray2
         *
         * @return array
         */
        protected function arrayRecursiveDiff($aArray1, $aArray2)
        {

            $aReturn = array();

            foreach ($aArray1 as $mKey => $mValue) {
                if (is_array($aArray2)) {
                    if (array_key_exists($mKey, $aArray2)) {
                        if (is_array($mValue)) {
                            $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                            if (count($aRecursiveDiff)) {
                                $aReturn[$mKey] = $aRecursiveDiff;
                            }
                        } else {
                            if ($mValue != $aArray2[$mKey]) {
                                $aReturn[$mKey] = $mValue;
                            }
                        }
                    } else {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            }

            return $aReturn;
        }
    }