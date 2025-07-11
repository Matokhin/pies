<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd41f42fd9bd3c7e2c5593a5e04bb57b1
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

        spl_autoload_register(array('ComposerAutoloaderInitd41f42fd9bd3c7e2c5593a5e04bb57b1', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd41f42fd9bd3c7e2c5593a5e04bb57b1', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd41f42fd9bd3c7e2c5593a5e04bb57b1::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
