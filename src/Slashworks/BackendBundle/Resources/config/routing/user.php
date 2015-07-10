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
     * @package     Slashworks\BackendBundle
     *
     */

    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RouteCollection;

    $collection = new RouteCollection();

    $collection->add('backend_system_user', new Route('/backend/system/user', array(
        '_controller' => 'SlashworksBackendBundle:User:index',
    )));

    $collection->add('backend_system_user_show', new Route('/backend/system/user/{id}/show', array(
        '_controller' => 'SlashworksBackendBundle:User:show',
    )));

    $collection->add('backend_system_user_new', new Route('/backend/system/user/new', array(
        '_controller' => 'SlashworksBackendBundle:User:new',
    )));

    $collection->add('backend_system_user_create', new Route(
        '/backend/system/user/create',
        array('_controller' => 'SlashworksBackendBundle:User:create'),
        array('_method' => 'post')
    ));

    $collection->add('backend_system_user_edit', new Route('/backend/system/user/{id}/edit', array(
        '_controller' => 'SlashworksBackendBundle:User:edit',
    )));

    $collection->add('backend_system_user_update', new Route(
        '/backend/system/user/{id}/update',
        array('_controller' => 'SlashworksBackendBundle:User:update'),
        array('_method' => 'post|put')
    ));

    $collection->add('backend_system_user_delete', new Route(
        '/backend/system/user/{id}/delete',
        array('_controller' => 'SlashworksBackendBundle:User:delete')
    ));

    return $collection;
