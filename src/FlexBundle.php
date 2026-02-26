<?php

/**
 * This file is part of FlexBundle for Contao
 *
 * @package     tdoescher/flex-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

namespace tdoescher\FlexBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class FlexBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/controller.yaml');
        $container->import('../config/listener.yaml');
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
