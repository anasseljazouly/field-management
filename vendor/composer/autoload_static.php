<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit701c41d5cd3bf2620a2d065ebaa62a42
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit701c41d5cd3bf2620a2d065ebaa62a42::$classMap;

        }, null, ClassLoader::class);
    }
}