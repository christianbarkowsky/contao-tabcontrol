<?php

declare(strict_types=1);

/**
 * Plenta Protected Select Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2015-2022, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @license       http://opensource.org/licenses/lgpl-3.0.html
 * @link          https://github.com/plenta/
 */

namespace Plenta\TabControl\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PlentaTabControlExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
