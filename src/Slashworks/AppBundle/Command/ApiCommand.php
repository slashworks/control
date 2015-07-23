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
     * @since       14.01.15 17:01
     * @package     Slashworks\AppBundle
     *
     */

    namespace Slashworks\AppBundle\Command;

    use Slashworks\AppBundle\Model\RemoteApp;
    use Slashworks\AppBundle\Model\RemoteAppQuery;
    use Slashworks\AppBundle\Model\RemoteHistoryContao;
    use Slashworks\AppBundle\Services\Api;
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Component\Console\Formatter\OutputFormatterStyle;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    /**
     * Class ApiCommand
     *
     * @package Slashworks\AppBundle\Command
     */
    class ApiCommand extends SlashworksCommand
    {

        /**
         *  configure cli command for making api calls
         */
        protected function configure()
        {

            // get systemname
            $sAppName = SystemSettings::get('app_name');

            // set cli options
            $this->setName($sAppName . ':remote:cron')->addOption('app', null, InputOption::VALUE_REQUIRED, 'run only for specific remote app', false)->addOption('force', null, InputOption::VALUE_NONE, 'force to run remote app / ignore cron settings')->setDescription('Run/Crawl registered remote apps');
        }


        /**
         * execute api command
         *
         * @param \Symfony\Component\Console\Input\InputInterface   $input
         * @param \Symfony\Component\Console\Output\OutputInterface $output
         *
         * @return void
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            // define colors if verbose
            if ($input->hasOption('verbose')) {
                if ($input->getOption('verbose')) {
                    $oErrStyle  = new OutputFormatterStyle('red', null, array('bold'));
                    $oOkStyle   = new OutputFormatterStyle('green', null, array('bold'));
                    $oLogoStyle = new OutputFormatterStyle('cyan', null);
                    $output->getFormatter()->setStyle('err', $oErrStyle);
                    $output->getFormatter()->setStyle('ok', $oOkStyle);
                    $output->getFormatter()->setStyle('sw', $oLogoStyle);
                }
            }

            // define colors if verbose
            if ($input->hasOption('verbose')) {
                if ($input->getOption('verbose')) {
                    $this->_printLogo($output);
                }
            }

            $bForce = false;
            $sAppId = $input->getOption('app');
            if ($input->hasOption('force')) {
                $bForce = ($input->getOption('force'));
            }

            // run command for single app?
            if (!$sAppId) {
                // Get active remote apps
                $aRemoteApps = RemoteAppQuery::create()->findByActivated(true);
            } else {
                $oRemoteApp  = RemoteAppQuery::create()->findOneById($sAppId);
                $aRemoteApps = array($oRemoteApp);
            }

            $iCnt       = 0;
            $iStarttime = microtime(true);

            // iterate through apps and run api call
            foreach ($aRemoteApps as $oRemoteApp) {
                // get cron string
                $sCron = $oRemoteApp->getCron();
                if (strlen($sCron) > 1) {
                    // parse cronstring and check time
                    $bRun = $this->_parseCrontab(date('d.m.Y H:i'), $oRemoteApp->getCron());
                    if ($bRun || $bForce) {
                        if ($input->hasOption('verbose')) {
                            if ($input->getOption('verbose')) {
                                $output->write('     ' . date('d.m.Y H:i') . ' <comment>Job:</comment> <fg=magenta>' . $oRemoteApp->getName() . '</fg=magenta> <comment>runnning...</comment>');
                            }
                        }

                        // make api call
                        $aResponse = $this->_makeCall($oRemoteApp);


                        // save response to database
                        $this->_saveResponse($aResponse, $oRemoteApp);

                        // print status if verbose
                        if ($input->hasOption('verbose')) {
                            if ($input->getOption('verbose')) {
                                $output->write("\t\t" . $this->_getStatus($aResponse['status']) . "\n");
                            }else {
                                $output->write(json_encode($aResponse));
                            }
                        }else {
                            $output->write(json_encode($aResponse));
                        }
                        $iCnt++;

                    } else {
                        // current app ignored because of cronsettings
                        if ($input->hasOption('verbose')) {
                            if ($input->getOption('verbose')) {
                                $output->write('     ' . date('d.m.Y H:i') . ' <fg=magenta>' . $oRemoteApp->getName() . "</fg=magenta> <comment>not running because of cron settings.</comment>\n");
                            }
                        }
                    }
                }
            }

            // calculate elapsed time
            if ($input->hasOption('verbose')) {
                if ($input->getOption('verbose')) {
                    $iEndtime = microtime(true);
                    $iSeconds = round($iEndtime - $iStarttime);
                    $iMinutes = round($iSeconds / 60);
                    if ($iSeconds < 10) {
                        $iSeconds = '0' . $iSeconds;
                    }
                    $iHour = round($iMinutes / 60);
                    if ($iMinutes < 10) {
                        $iMinutes = '0' . $iMinutes;
                    }
                    if ($iHour < 10) {
                        $iHour = '0' . $iHour;
                    }

                    // green text
                    $output->writeln("\n<fg=white;options=bold>     " . $iCnt . ' Job(s) done in ' . $iHour . ':' . $iMinutes . ':' . $iSeconds . "</fg=white;options=bold>\n");
                }
            }

        }


        /**
         * Parse cron time string
         *
         * @param $sDatetime
         * @param $sCrontab
         *
         * @return mixed
         */
        private function _parseCrontab($sDatetime, $sCrontab)
        {

            $aTime    = explode(' ', date('i G j n w', strtotime($sDatetime)));
            $sCrontab = explode(' ', $sCrontab);
            foreach ($sCrontab as $k => &$v) {
                $v = explode(',', $v);
                foreach ($v as &$v1) {
                    $v1 = preg_replace(array(
                                           '/^\*$/',
                                           '/^\d+$/',
                                           '/^(\d+)\-(\d+)$/',
                                           '/^\*\/(\d+)$/'
                                       ), array(
                                           'true',
                                           intval($aTime[$k]) . '===\0',
                                           '(\1<=' . intval($aTime[$k]) . ' and ' . intval($aTime[$k]) . '<=\2)',
                                           intval($aTime[$k]) . '%\1===0'
                                       ), $v1);
                }
                $v = '(' . implode(' or ', $v) . ')';
            }
            $sCrontab = implode(' and ', $sCrontab);

            return eval('return ' . $sCrontab . ';');
        }


        /**
         * perform api call
         *
         * @param RemoteApp $oRemoteApp
         *
         * @return mixed
         */
        private function _makeCall($oRemoteApp)
        {

            // get class
            $this->getContainer()->get('API');
            // do call
            $aReturn = Api::call('getData', array(
                array(
                    'log'    => $oRemoteApp->getIncludelog(),
                    'format' => 'json'
                )
            ), $oRemoteApp->getFullApiUrl(), $oRemoteApp->getPublicKey(), $oRemoteApp);

            // build json response
            $sStatuscode = $aReturn['statuscode'];
            $aReturn     = json_decode($aReturn['result'], true);
            if (!isset($aReturn['status'])) {
                $aReturn['status'] = true;
            }
            $aReturn['statuscode'] = $sStatuscode;

            if($sStatuscode != 200) {
                $this->getContainer()->get('logger')->error("ERROR in ".__FILE__." on line ".__LINE__." - ".json_encode($aReturn), array("Method"    => __METHOD__,
                                                                     "RemoteApp" => $oRemoteApp->getName(),
                                                                     "RemoteURL" => $oRemoteApp->getFullApiUrl()
                ));
            }

            return $aReturn;
        }


        /**
         * Save response to database
         *
         * @param array     $aResponse
         * @param RemoteApp $oRemoteApp
         *
         * @throws \Exception
         *
         * @return void
         */
        private function _saveResponse($aResponse, $oRemoteApp)
        {

            // get model by app-type
            $sClassName      = '\Slashworks\AppBundle\Model\RemoteHistory' . ucfirst($oRemoteApp->getType());
            $sQueryClassName = '\Slashworks\AppBundle\Model\RemoteHistory' . ucfirst($oRemoteApp->getType() . 'Query');

            // if class exists, proceed...
            if (class_exists($sClassName)) {
                // find histories for remote-app
                $aHistories = $sQueryClassName::create()->findByRemoteAppId($oRemoteApp->getId());

                // create new history-entry
                $oRemoteHistoryClass = new $sClassName();
                $oRemoteHistoryClass->setRemoteApp($oRemoteApp);
                $oRemoteHistoryClass->setData($aResponse);

                // convert created class to array for comparsion
                $aNewHistory               = $oRemoteHistoryClass->toArray();
                $aNewHistory['Extensions'] = $aNewHistory['Extensions']->getArrayCopy();
                if (is_object($aNewHistory['Log'])) {
                    $aNewHistory['Log'] = $aNewHistory['Log']->getArrayCopy();
                } else {
                    $aNewHistory['Log'] = array();
                }
                unset($aNewHistory['Id']);


                // interate old histories and convert to array for comparsion
                foreach ($aHistories as $oHistory) {
                    $aHistory               = $oHistory->toArray();
                    $aHistory['Extensions'] = $aHistory['Extensions']->getArrayCopy();
                    if (is_object($aHistory['Log'])) {
                        $aHistory['Log'] = $aHistory['Log']->getArrayCopy();
                    } else {
                        $aHistory['Log'] = array();
                    }

                    unset($aHistory['Id']);

                    // if api-call was not successful, send notifiations if configured
                    if ($aResponse['statuscode'] != 200) {
                        if ($oRemoteApp->checkNotificationSetting("NotificationError")) {
                            $this->_sendErrorNotification($oRemoteApp, $aResponse);
                        }
                    } else {
                        // if api-call was successful, compare old and new history and send differences to user
                        $aNew = $this->arrayRecursiveDiff($aNewHistory, $aHistory);
                        // diff exists?
                        if (!empty($aNew) && $oRemoteApp->checkNotificationSetting("NotificationChange")) {
                            $aOld = $this->arrayRecursiveDiff($aHistory, $aNewHistory);
                            $this->_sendNotification(array(
                                                         'old' => $aOld,
                                                         'new' => $aNew
                                                     ), $oRemoteApp, $aNewHistory);
                        }
                    }
                    // delete old history
                    $oHistory->delete();
                }

                // save created history
                $oRemoteHistoryClass->save();
                $oRemoteApp->setLastRun(time());
                $oRemoteApp->save();

            } else {
                $this->getContainer()->get('logger')->error('Class \'' . $sClassName . '\' not found... ', array("Method"    => __METHOD__,
                                                                                                                                         "RemoteApp" => $oRemoteApp->getName(),
                                                                                                                                         "RemoteURL" => $oRemoteApp->getFullApiUrl()
                ));
                throw new \Exception('Class \'' . $sClassName . '\' not found... ');
            }
        }


        /**
         * Send Error-Notification to user
         *
         * @param $oRemoteApp
         * @param $aResponse
         */
        private function _sendErrorNotification(&$oRemoteApp, $aResponse)
        {

            $iStatusCode = $aResponse['statuscode'];
            /*
             * Parse template by statuscode
             */
            if ($iStatusCode === 404) {
                $sHtml = $this->getContainer()->get('templating')->render('SlashworksAppBundle:Email:cron_error_404_notification.html.twig', array(
                    'remote_app' => $oRemoteApp,
                    'response'   => $aResponse,
                    'controlurl' => $this->_getSiteURL()
                ));
            } elseif ($iStatusCode === 500) {
                $sHtml = $this->getContainer()->get('templating')->render('SlashworksAppBundle:Email:cron_error_500_notification.html.twig', array(
                    'remote_app' => $oRemoteApp,
                    'response'   => $aResponse,
                    'controlurl' => $this->_getSiteURL()
                ));
            } elseif ($iStatusCode === 403) {
                $sHtml = $this->getContainer()->get('templating')->render('SlashworksAppBundle:Email:cron_error_403_notification.html.twig', array(
                    'remote_app' => $oRemoteApp,
                    'response'   => $aResponse,
                    'controlurl' => $this->_getSiteURL()
                ));
            } else {
                $sHtml = $this->getContainer()->get('templating')->render('SlashworksAppBundle:Email:cron_error_notification.html.twig', array(
                    'remote_app' => $oRemoteApp,
                    'response'   => $aResponse,
                    'controlurl' => $this->_getSiteURL()
                ));
            }

            // translate Subject
            $sSubject = $this->getContainer()->get('translator')->trans('system.email.error.' . $iStatusCode . '.subject');

            // get recipients and sender
            $sRecipient = $oRemoteApp->getNotificationRecipient();
            $sSender    = $oRemoteApp->getNotificationSender();
            $sMessage   = \Swift_Message::newInstance()->setSubject($sSubject)->setFrom($sSender)->setTo($sRecipient)->setContentType('text/html')->setBody($sHtml, 'text/html')->addPart($sHtml, 'text/html');

            // send notification
            $this->getContainer()->get('mailer')->send($sMessage);
        }


        /**
         * Send Notification to user
         *
         * @param array               $aDiff
         * @param RemoteApp           $oRemoteApp
         * @param RemoteHistoryContao $aNewHistory
         *
         * @return void
         */
        private function _sendNotification($aDiff, &$oRemoteApp, $aNewHistory)
        {

            // parse template
            $sHtml = $this->getContainer()->get('templating')->render('SlashworksAppBundle:Email:cron_notification.html.twig', array(
                'diff'       => $aDiff,
                'log'        => $aNewHistory['Log'],
                'remote_app' => $oRemoteApp,
                'controlurl' => $this->_getSiteURL()
            ));

            // get recipients
            $sRecipient = $oRemoteApp->getNotificationRecipient();
            // get sender
            $sSender = $oRemoteApp->getNotificationSender();

            // set subject and body of mail
            $sMessage = \Swift_Message::newInstance()->setSubject($this->getContainer()->get('translator')->trans('system.email.change.subject'))->setFrom($sSender)->setTo($sRecipient)->setContentType('text/html')->setBody($sHtml, 'text/html')->addPart($sHtml, 'text/html');

            // send email
            $this->getContainer()->get('mailer')->send($sMessage);
        }


        /**
         * Get status for commandline
         *
         * @param $iStatuscode
         *
         * @return string
         */
        private function _getStatus($iStatuscode)
        {

            $sStatus = '[<ok>OK</ok>]';
            if ($iStatuscode != 200) {
                $sStatus = '[<err>ERROR</err>]';
            }

            return $sStatus;
        }

    }