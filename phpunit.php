<?php
/**
 * @author Stefano Torresi (http://stefanotorresi.it)
 * @license See the file LICENSE.txt for copying permission.
 * ************************************************
 */

use Composer\Autoload\ClassLoader;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

$loader = require 'vendor/autoload.php';

if (! $loader instanceof ClassLoader) {
    throw new \RuntimeException("Autoloader could not be found. Did you run 'composer install --dev'?");
}

unset($loader);
