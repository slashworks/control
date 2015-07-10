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
      * @since       10.07.2015 10:27
      * @package     Slashworks\AppBundle
      *
      */
    use Symfony\Component\DependencyInjection\Definition;

    $container->setDefinition('API', new Definition(
        'Slashworks\AppBundle\Services\Api',
        array()
    ));