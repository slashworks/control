<?php

    use Symfony\Component\Config\Loader\LoaderInterface;
    use Symfony\Component\HttpKernel\Kernel;

    /**
     * Class AppKernel
     */
    class AppKernel extends Kernel
    {


        public function __construct($environment, $debug)
        {

            if(!ini_get('date.timezone') || !date_default_timezone_get()){
                $timezone = 'Europe/Berlin';
                if (is_link('/etc/localtime')) {
                    // Mac OS X (and older Linuxes)
                    // /etc/localtime is a symlink to the
                    // timezone in /usr/share/zoneinfo.
                    $filename = readlink('/etc/localtime');
                    if (strpos($filename, '/usr/share/zoneinfo/') === 0) {
                        $timezone = substr($filename, 20);
                    }
                } elseif (file_exists('/etc/timezone')) {
                    // Ubuntu / Debian.
                    $data = file_get_contents('/etc/timezone');
                    if ($data) {
                        $timezone = $data;
                    }
                } elseif (file_exists('/etc/sysconfig/clock')) {
                    // RHEL / CentOS
                    $data = parse_ini_file('/etc/sysconfig/clock');
                    if (!empty($data['ZONE'])) {
                        $timezone = $data['ZONE'];
                    }
                }
                date_default_timezone_set($timezone);
            }

            parent::__construct($environment, $debug);
        }



        /**
         * @return array
         */
        public function registerBundles()
        {

            $bundles = array(
                new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
                new Symfony\Bundle\SecurityBundle\SecurityBundle(),
                new Symfony\Bundle\TwigBundle\TwigBundle(),
                new Symfony\Bundle\MonologBundle\MonologBundle(),
                new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
                new Symfony\Bundle\AsseticBundle\AsseticBundle(),
                new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
                new Slashworks\BackendBundle\SlashworksBackendBundle(),
                new Propel\PropelBundle\PropelBundle(),
                new Slashworks\AppBundle\SlashworksAppBundle(),
            );

            if (in_array($this->getEnvironment(), array('dev', 'test'))) {
                $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
                $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            }

            return $bundles;
        }


        /**
         * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
         */
        public function registerContainerConfiguration(LoaderInterface $loader)
        {

            $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
        }
    }
