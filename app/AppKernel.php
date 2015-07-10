<?php

    use Symfony\Component\Config\Loader\LoaderInterface;
    use Symfony\Component\HttpKernel\Kernel;

    /**
     * Class AppKernel
     */
    class AppKernel extends Kernel
    {

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
