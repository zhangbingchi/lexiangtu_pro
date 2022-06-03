<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita2d60bfdb2d9eef0d397b9a49bc7a186
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInita2d60bfdb2d9eef0d397b9a49bc7a186', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita2d60bfdb2d9eef0d397b9a49bc7a186', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita2d60bfdb2d9eef0d397b9a49bc7a186::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInita2d60bfdb2d9eef0d397b9a49bc7a186::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequirea2d60bfdb2d9eef0d397b9a49bc7a186($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequirea2d60bfdb2d9eef0d397b9a49bc7a186($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}