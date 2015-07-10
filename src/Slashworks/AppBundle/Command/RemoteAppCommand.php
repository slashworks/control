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
    use Slashworks\BackendBundle\Model\SystemSettings;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Formatter\OutputFormatterStyle;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Validator\Constraints\DateTime;

    /**
     * Class RemoteAppCommand
     *
     * @package Slashworks\AppBundle\Command
     */
    class RemoteAppCommand extends SlashworksCommand
    {

        /**
         *  configure cli command for listing remoteapps
         */
        protected function configure()
        {

            $appName = SystemSettings::get("app_name");

            $this
                ->setName($appName.':remote:list')
                ->setDescription('List remote apps with their id\'s and status');
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
            $aData = array();
            // set colors and formats
            $oErrStyle  = new OutputFormatterStyle('red', null, array('bold'));
            $oOkStyle   = new OutputFormatterStyle('green', null, array('bold'));
            $oLogoStyle = new OutputFormatterStyle('cyan', null);
            $output->getFormatter()->setStyle('err', $oErrStyle);
            $output->getFormatter()->setStyle('ok', $oOkStyle);
            $output->getFormatter()->setStyle('sw', $oLogoStyle);

            // print logo
            $this->_printLogo($output);


            // Get active remote apps
            $aRemoteApps = RemoteAppQuery::create()->findByActivated(true);
            /** @var RemoteApp $oRemoteApp */
            $iCnt       = 0;
            foreach ($aRemoteApps as $oRemoteApp) {
                // get cron string
                $aData[] = array(
                    $oRemoteApp->getId(),
                    $oRemoteApp->getName(),
                    $oRemoteApp->getLastRun()->format("d.m.Y H:i:s"),
                );
                $iCnt++;
            }

            // get tablehelper for cli
            $oTable = $this->getHelper('table');
            $oTable
                ->setHeaders(array('ID', 'Title', 'Lastrun'))
                ->setRows($aData)
            ;
            $oTable->render($output);

            // green text
            $output->writeln("\n<fg=white;options=bold>     " . $iCnt . " Job(s) found</fg=white;options=bold>\n");

        }

    }