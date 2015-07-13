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
     * @since       06.01.15 10:26
     * @package     Slashworks\AppBundle
     *
     */

    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RouteCollection;

    $collection = new RouteCollection();

    $collection->addCollection(
        $loader->import("@SlashworksAppBundle/Resources/config/routing/customer.php")
    );

    $collection->addCollection(
        $loader->import("@SlashworksAppBundle/Resources/config/routing/remote_app.php")
    );


    $collection->add('license_activate', new Route('/backend/license/activate', array(
        '_controller' => 'SlashworksAppBundle:License:activateLicense',
    )));


    $collection->add('license_edit', new Route('/backend/license/edit', array(
        '_controller' => 'SlashworksAppBundle:License:edit',
    )));

    $collection->add('about', new Route('/backend/about', array(
        '_controller' => 'SlashworksAppBundle:About:about',
    )));

    $collection->add('license_update', new Route('/backend/license/update', array(
        '_controller' => 'SlashworksAppBundle:License:update'
    ), array('_method' => 'post|put')
    ));


    $collection->add('notification_center_index', new Route('/backend/notificationcenter', array(
        '_controller' => 'SlashworksAppBundle:NotificationCenter:index',
    )));

    $collection->add('notification_center_update', new Route('/backend/notificationcenter/update', array(
        '_controller' => 'SlashworksAppBundle:NotificationCenter:update',
        array('_method' => 'post|put')
    )));


    return $collection;