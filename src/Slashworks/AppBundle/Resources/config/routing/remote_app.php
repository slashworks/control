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

    $collection->add('remote_app', new Route('/backend/remoteapp', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:index',
    )));
    $collection->add('remote_app_ajax', new Route('/backend/remoteapp/ajax', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:indexData',
    )));

    $collection->add('remote_api_update', new Route('/api/update', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:updateApi',
    )));
    $collection->add('remote_api_init', new Route('/backend/api/init/{id}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:generateInitialApiZip',
    )));

    $collection->add('remote_api_install', new Route('/backend/api/install/{id}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:initInstallCall',
    )));

    $collection->add('remote_api_init_update', new Route('/backend/api/update/{id}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:initUpdateCall',
    )));

    $collection->add('remote_app_show', new Route('/backend/remoteapp/{id}/show', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:show',
    )));


    $collection->add('remote_app_new', new Route('/backend/remoteapp/new', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:new',
    )));
    $collection->add('remote_app_api_error', new Route('/backend/remoteapp/api/error/{code}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:error',
    )));

    $collection->add('remote_app_single_api_call', new Route('/backend/remoteapp/api/{id}/call', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:runSingleApiCall',
    )));
    $collection->add('remote_app_last_log', new Route('/backend/remoteapp/log/{id}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:lastLog',
    )));

    $collection->add('remote_app_create', new Route('/backend/remoteapp/create', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:create'
    ), array('_method' => 'post')
    ));

    $collection->add('remote_app_edit', new Route('/backend/remoteapp/{id}/edit', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:edit',
    )));

    $collection->add('remote_app_update', new Route('/backend/remoteapp/{id}/update', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:update'
    ), array('_method' => 'post|put')
    ));

    $collection->add('remote_app_delete', new Route('/backend/remoteapp/{id}/delete', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:delete'
    )));

    $collection->add('remote_app_details', new Route('/backend/remoteapp/details/{id}', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:details',
    )));

    return $collection;
