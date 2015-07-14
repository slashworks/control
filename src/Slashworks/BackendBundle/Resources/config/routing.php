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


    $collection->addCollection(
        $loader->import("@SlashworksBackendBundle/Resources/config/routing/user.php")
    );


    $collection->add('root', new Route('/', array(
        '_controller' => 'FrameworkBundle:Redirect:urlRedirect',
        'path'        => '/backend',
        'permanent'   => true,
    )));


    $collection->add('datatables_language_file', new Route('/backend/dt/languagefile/{sLang}', array(
        '_controller' => 'SlashworksBackendBundle:Backend:getDatatablesLanguagefile',
    )));


    $collection->add('login', new Route('/backend/login', array(
        '_controller' => 'SlashworksBackendBundle:Security:login'
    )));


    $collection->add('login_check', new Route('/backend/login_check', array()));


    $collection->add('logout', new Route('/backend/logout', array()));


    $collection->add('index', new Route('/backend', array(
        '_controller' => 'SlashworksAppBundle:RemoteApp:index',
    )));


    $collection->add('dashboard', new Route('/backend', array(
        '_controller' => 'SlashworksBackendBundle:Dashboard:index',
    )));

    $collection->add('system_user', new Route('/backend/system/user', array(
        '_controller' => 'SlashworksBackendBundle:User:index',
    )));

    $collection->add('system_user_edit', new Route('/backend/system/user/edit/{id}', array(
        '_controller' => 'SlashworksBackendBundle:User:edit',
        'id'          => false
    )));

    $collection->add('system_user_delete', new Route('/backend/system/user/delete/{id}', array(
        '_controller' => 'SlashworksBackendBundle:User:delete',
    )));

    $collection->add('system_user_update', new Route('/backend/system/user/update', array(
        '_controller' => 'SlashworksBackendBundle:User:update',
    ), array(), array(), '', array(), array('POST')));

    $collection->add('install_license', new Route('/install/license', array(
        '_controller' => 'SlashworksBackendBundle:Install:license',
    ), array(), array(), '', array(), array('GET')));


    $collection->add('install_license_agree', new Route('/install/license/agree', array(
        '_controller' => 'SlashworksBackendBundle:Install:licenseAgree',
    ), array(), array(), '', array(), array('GET')));

    $collection->add('install_requirements', new Route('/install/requirements', array(
        '_controller' => 'SlashworksBackendBundle:Install:requirements',
    ), array(), array(), '', array(), array('GET')));


    $collection->add('install', new Route('/install/data', array(
        '_controller' => 'SlashworksBackendBundle:Install:install',
    ), array(), array(), '', array(), array('GET')));

    $collection->add('install_process', new Route('/install/data', array(
        '_controller' => 'SlashworksBackendBundle:Install:processInstall',
    ), array(), array(), '', array(), array('POST')));


    return $collection;