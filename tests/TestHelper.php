<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/14/2017
 * Time: 3:29 AM
 */

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);
define('MODEL_PATH', __DIR__ . '/../app/models/');


set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// Required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";


$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
        MODEL_PATH
    ]
);


$loader->registerNamespaces(
    array(
        'Models' =>'../models',
        'Utils' => '../models/utils/'
    )
);
$loader->register();

$di = new FactoryDefault();

Di::reset();



Di::setDefault($di);
