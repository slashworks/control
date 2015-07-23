<?php


    namespace Slashworks\BackendBundle\Helper;

    use Slashworks\BackendBundle\Model\User;
    use Symfony\Bundle\FrameworkBundle\Command\AssetsInstallCommand;
    use Symfony\Component\Console\Input\ArgvInput;
    use Symfony\Component\Console\Output\NullOutput;
    use Symfony\Component\Process\Process;
    use Symfony\Component\Security\Acl\Exception\Exception;
    use Symfony\Component\Yaml\Dumper;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class InstallHelper
     *
     * @package Slashworks\BackendBundle\Helper
     */
    class InstallHelper
    {

        /**
         * @var
         */
        private static $_container;

        /**
         * @var
         */
        private static $_data;

        /**
         * @var
         */
        private static $_connection;


        /**
         * @param $oContainer
         * @param $aData
         *
         * @throws \Exception
         */
        public static function doInstall(&$oContainer, &$aData)
        {

            // init class vars
            self::_init($oContainer, $aData);

            // check provided database credentials
            if (self::_checkDatabaseCredentials()) {

                // write symfony's parameters.yml
                 self::_saveSystemConfig();

                 // insert default database dump
                self::_insertDump();

                // create admin user
                 self::_createAdminUser();

                // insert control-url to settgins-db
                 self::_saveControlUrl();

                // reset the assetic configs
                 self::resetAsseticConfig();

                //create keys
                self::createKeys();

                // clears caches and dumps assets
                self::clearCache();

            } else {
                throw new \Exception(self::$_container->get("translator")->trans("install.bad_database_credentials"));
            }
        }


        public static function createKeys(){
            $rsa = new \Crypt_RSA();
            $aKeys = $rsa->createKey(512);
            if(empty($aKeys)){
                throw new \Exception("Key generation failed...");
            }

            $sKeyPath = __DIR__."/../../AppBundle/Resources/private/api/keys/server/";
            file_put_contents($sKeyPath."private.key",$aKeys['privatekey']);
            file_put_contents($sKeyPath."public.key",$aKeys['publickey']);

        }

        /**
         * reset assitx-config not to use controller
         */
        private static function resetAsseticConfig()
        {

            return;

            /**
             * dev
             */
            $aYaml                              = Yaml::parse(file_get_contents(self::$_container->get('kernel')->getRootDir() . '/config/config_dev.yml'));
            $aYaml['assetic']['use_controller'] = false;
            $sNewYaml                           = Yaml::dump($aYaml, 5);
            file_put_contents(self::$_container->get('kernel')->getRootDir() . '/config/config_dev.yml', $sNewYaml);


            /**
             * prod
             */
            $aYaml                              = Yaml::parse(file_get_contents(self::$_container->get('kernel')->getRootDir() . '/config/config_prod.yml'));
            $aYaml['assetic']['use_controller'] = false;
            $sNewYaml                           = Yaml::dump($aYaml, 5);
            file_put_contents(self::$_container->get('kernel')->getRootDir() . '/config/config_prod.yml', $sNewYaml);
        }


        /**
         * @param $dir
         *
         * @return bool
         */
        private static function deleteTree($dir) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? self::deleteTree("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }


        /**
         * @throws \Exception
         */
        private static function clearCache()
        {

            $sProdCache = self::$_container->get('kernel')->getRootDir() . "/cache/prod";
            $sDevCache = self::$_container->get('kernel')->getRootDir() . "/cache/dev";
            if(is_dir($sProdCache)) {
                self::deleteTree($sProdCache);
            }
            if(is_dir($sDevCache)) {
                self::deleteTree($sDevCache);
            }


            $command = new AssetsInstallCommand();
            $command->setContainer(self::$_container);
            $input  = new ArgvInput(array('assets:install', self::$_container->get('kernel')->getRootDir() . "/../web"));
            $output = new NullOutput();
            $command->run($input, $output);

            $process = new Process('cd ' . self::$_container->get('kernel')->getRootDir() . ' && php console assetic:dump');
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
        }


        /**
         * @param $oContainer
         * @param $aData
         */
        private static function _init($oContainer, $aData)
        {

            self::$_container = $oContainer;
            self::$_data      = $aData['slashworks_backendbundle_install'];
        }


        /**
         * save control-url to database
         */
        private static function _saveControlUrl()
        {


            $oStatement = self::$_connection->prepare('INSERT INTO  `system_settings` (`key` ,`value`)VALUES (:key,  :value);');
            $oResult    = $oStatement->execute(array(
                                                   ":key"   => "control_url",
                                                   ":value" => self::$_data['controlUrl'],
                                               ));

            if ($oResult !== true) {
                throw new Exception("Error while inserting control url");
            }

            $oStatement = self::$_connection->prepare('INSERT INTO `license` (`id`, `max_clients`, `domain`, `serial`, `valid_until`) VALUES (null, 0, :control_url , \'\', 0);');
            $oResult    = $oStatement->execute(array(
                                                   ":control_url" => self::$_data['controlUrl'],
                                               ));


        }


        /**
         * save systemconfig to parameters.yml
         */
        private static function _saveSystemConfig()
        {

            $sYmlDump = array(
                'parameters' => array(
                    'database_driver'   => self::checkEmpty(self::$_data['dbDriver']),
                    'database_host'     => self::checkEmpty(self::$_data['dbHost']),
                    'database_port'     => self::checkEmpty(self::$_data['dbPort']),
                    'database_name'     => self::checkEmpty(self::$_data['dbName']),
                    'database_user'     => self::checkEmpty(self::$_data['dbUser']),
                    'database_password' => self::checkEmpty(self::$_data['dbPassword']),
                    'mailer_transport'  => self::checkEmpty(self::$_data['mailerTransport']),
                    'mailer_host'       => self::checkEmpty(self::$_data['mailerHost']),
                    'mailer_user'       => self::checkEmpty(self::$_data['mailerUser']),
                    'mailer_password'   => self::checkEmpty(self::$_data['mailerPassword']),
                    'locale'            => 'de',
                    'secret'            => md5(uniqid(null, true)),
                ),
            );


            $oDumper = new Dumper();
            $sYaml   = $oDumper->dump($sYmlDump, 99, 0, true, false);
            $sPath   = __DIR__ . '/../../../../app/config/parameters.yml';
            $sYaml   = str_replace("'", '', $sYaml);
            file_put_contents($sPath, $sYaml);
        }


        /**
         * @param $sVal
         *
         * @return string
         */
        private static function checkEmpty($sVal)
        {

            if (empty($sVal)) {
                $sVal = chr(126);
            }

            return $sVal;
        }


        /**
         * @return bool
         */
        private static function _checkDatabaseCredentials()
        {

            try {
                $bResult           = true;
                self::$_connection = new \PDO(
                    'mysql:host=' . self::$_data['dbHost'] . ';dbname=' . self::$_data['dbName'],
                    self::$_data['dbUser'],
                    self::$_data['dbPassword']
                );

            } catch (\PDOException $e) {
                $bResult = false;
            }


            return $bResult;
        }


        /**
         * @return bool
         */
        private static function _insertDump()
        {


            $sStructureDump = file_get_contents(__DIR__ . "/../../../../app/Resources/data/database.sql");
            $iResult        = self::$_connection->exec($sStructureDump);

            if ($iResult === false) {
                throw new Exception("Error while excecuting database query... ");
            }

            $sDataDump = file_get_contents(__DIR__ . "/../../../../app/Resources/data/data.sql");
            $iResult   = self::$_connection->exec($sDataDump);


            if ($iResult === false) {
                throw new Exception("Error while excecuting database query... ");
            }


            return true;
        }


        /**
         * create the admin user
         */
        private static function _createAdminUser()
        {

            $oUser     = new User();
            $factory   = self::$_container->get('security.encoder_factory');
            $encoder   = $factory->getEncoder($oUser);
            $sSalt     = $oUser->getSalt();
            $sPassword = $encoder->encodePassword(self::$_data['adminPassword'], $sSalt);


            $oStatement = self::$_connection->prepare('INSERT INTO `user` (`id`, `username`, `password`, `salt`, `firstname`, `lastname`, `email`, `phone`, `memo`, `activated`, `last_login`, `notification_change`, `notification_error`) VALUES (null, :adminUser, :adminPassword , :adminPasswordSalt, \'admin\', \'admin\', :adminEmail, \'\', \'\', 1, \'0000-00-00 00:00:00\', 1, 1);');
            $oResult    = $oStatement->execute(array(
                                                   ":adminUser"         => self::$_data['adminUser'],
                                                   ":adminPassword"     => $sPassword,
                                                   ":adminPasswordSalt" => $sSalt,
                                                   ":adminEmail"        => self::$_data['adminEmail'],
                                               ));

            if ($oResult !== true) {
                throw new Exception("Error while creating admin user");
            }

            $iUserId = self::$_connection->lastInsertId();

            $oStatement = self::$_connection->prepare('INSERT INTO  `user_role` (`user_id` ,`role_id`)VALUES (:user_id,  :user_role_id);');
            $oResult    = $oStatement->execute(array(
                                                   ":user_id"      => $iUserId,
                                                   ":user_role_id" => 6,
                                               ));

            if ($oResult !== true) {
                throw new Exception("Error while creating admin user");
            }

        }


    }