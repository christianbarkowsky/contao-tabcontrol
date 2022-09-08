<?php

declare(strict_types=1);

/**
 * Jobs Application Flow Bundle
 *
 * @copyright     Copyright (c) 2022, Plenta
 * @author        Plenta <https://plenta.io>
 * @link          https://jobboerse-software.de
 * @license       proprietary
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

/** @var ContainerBuilder $container */
$fileSystem = new Filesystem();
$projectDir = $container->getParameter('kernel.project_dir');

if ($fileSystem->exists($projectDir.'/web')) {
    $webDir = 'web'; // backwards compatibility
} else {
    $webDir = 'public';
}

$container->loadFromExtension('framework', [
    'assets' => [
        'packages' => [
            'plentatabcontrol' => [
                'json_manifest_path' => '%kernel.project_dir%/'.$webDir.'/bundles/plentatabcontrol/webpack/manifest.json',
            ],
        ],
    ],
]);
