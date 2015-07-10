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

    $collection->add('backend_system_customer', new Route('/backend/system/customer', array(
        '_controller' => 'SlashworksAppBundle:Customer:index',
    )));

    $collection->add('backend_system_customer_show', new Route('/backend/system/customer/{id}/show', array(
        '_controller' => 'SlashworksAppBundle:Customer:show',
    )));
    $collection->add('backend_system_customer_info', new Route('/backend/system/customer/{id}/info', array(
        '_controller' => 'SlashworksAppBundle:Customer:modalInfo',
    )));

    $collection->add('backend_system_customer_new', new Route('/backend/system/customer/new', array(
        '_controller' => 'SlashworksAppBundle:Customer:new',
    )));

    $collection->add('backend_system_customer_create', new Route('/backend/system/customer/create',
        array('_controller' => 'SlashworksAppBundle:Customer:create'),
        array('_method' => 'post')
    ));

    $collection->add('backend_system_customer_edit', new Route('/backend/system/customer/{id}/edit', array(
        '_controller' => 'SlashworksAppBundle:Customer:edit',
    )));

    $collection->add('backend_system_customer_update', new Route('/backend/system/customer/{id}/update',
        array('_controller' => 'SlashworksAppBundle:Customer:update'),
        array('_method' => 'post|put')
    ));

    $collection->add('backend_system_customer_delete', new Route('/backend/system/customer/{id}/delete',
        array('_controller' => 'SlashworksAppBundle:Customer:delete')
    ));

    return $collection;
