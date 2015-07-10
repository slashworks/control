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
  * @since       10.07.2015 10:25
  * @package     Slashworks\AppBundle
  *
  */
namespace Slashworks\AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Config implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('slashworks_app');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
