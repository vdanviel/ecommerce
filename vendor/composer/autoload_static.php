<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfecaa905fa8fa6c0c1b7ca03cf435ca2
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'chillerlan\\Settings\\' => 20,
            'chillerlan\\QRCode\\' => 18,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
            'PERSONAL\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'chillerlan\\Settings\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-settings-container/src',
        ),
        'chillerlan\\QRCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-qrcode/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'PERSONAL\\' => 
        array (
            0 => __DIR__ . '/..' . '/PERSONAL/classes/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfecaa905fa8fa6c0c1b7ca03cf435ca2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfecaa905fa8fa6c0c1b7ca03cf435ca2::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitfecaa905fa8fa6c0c1b7ca03cf435ca2::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitfecaa905fa8fa6c0c1b7ca03cf435ca2::$classMap;

        }, null, ClassLoader::class);
    }
}
