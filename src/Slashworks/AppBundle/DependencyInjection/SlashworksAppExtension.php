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
  * @since       10.07.2015 10:24
  * @package     Slashworks\AppBundle
  *
  */
namespace Slashworks\AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SlashworksAppExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Config();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');
    }
}
