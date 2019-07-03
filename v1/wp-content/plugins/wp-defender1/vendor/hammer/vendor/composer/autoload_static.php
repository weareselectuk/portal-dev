<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit39041d1df823322d2fb005ab2f911bf2
{
    public static $files = array (
        'da253f61703e9c22a5a34f228526f05a' => __DIR__ . '/..' . '/wixel/gump/gump.class.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' =>
        array (
            'Psr\\Log\\' => 8,
        ),
        'K' =>
        array (
            'Katzgrau\\KLogger\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' =>
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Katzgrau\\KLogger\\' =>
        array (
            0 => __DIR__ . '/..' . '/katzgrau/klogger/src',
        ),
    );

    public static $classMap = array (
        'Katzgrau\\KLogger\\Logger' => __DIR__ . '/..' . '/katzgrau/klogger/src/Logger.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit39041d1df823322d2fb005ab2f911bf2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit39041d1df823322d2fb005ab2f911bf2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit39041d1df823322d2fb005ab2f911bf2::$classMap;

        }, null, ClassLoader::class);
    }
}