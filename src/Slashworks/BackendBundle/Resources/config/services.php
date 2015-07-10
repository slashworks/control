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

    use Symfony\Component\DependencyInjection\Definition;
    use Symfony\Component\DependencyInjection\Reference;
    use Symfony\Component\DependencyInjection\Parameter;


    $container
        ->register('slashworks.twig.extension', 'Slashworks\BackendBundle\Twig\SystemSettingsExtension')
        ->addTag('twig.extension');


    $container->setDefinition('install_helper', new Definition(
        'Slashworks\Backendbundle\Helper\InstallHelper',
        array()
    ));
/*

    $container->setDefinition(
        'slashworks_backend.example',
        new Definition(
            'Slashworks\BackendBundle\Example',
            array(
                new Reference('service_id'),
                "plain_value",
                new Parameter('parameter_name'),
            )
        )
    );

*/