<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/14/2017
 * Time: 3:56 AM
 */
namespace TestControllers;

use Phalcon\Http\Response;
use Phalcon\Mvc\View;

use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');



abstract class MainControllerPhalconTest extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;


    protected $_config;

    public function setUp()
    {
        parent::setUp();
        $di =Di::getDefault();




        $di->set('modelsManager', function (){
            return new \Phalcon\Mvc\Model\Manager();
        });

        $di->set('modelsMetadata', function (){
            return new \Phalcon\Mvc\Model\MetaData\Memory();
        });


        $dbConfig = new \Phalcon\Config([
            'database' => [
                'adapter'     => 'Mysql',
                'host'        => 'localhost',
                'username'    => 'root',
                'password'    => '',
                'dbname'      => 'vm_emulator',
                'charset'     => 'utf8',
            ],
            'application' => [
                'appDir'         => APP_PATH . '/',
                'controllersDir' => APP_PATH . '/controllers/',
                'modelsDir'      => APP_PATH . '/models/',
                'migrationsDir'  => APP_PATH . '/migrations/',
                'viewsDir'       => APP_PATH . '/views/',
                'pluginsDir'     => APP_PATH . '/plugins/',
                'libraryDir'     => APP_PATH . '/library/',
                'cacheDir'       => BASE_PATH . '/cache/',
                'baseUri'        => '/virtual-vm/',
            ]
        ]);

        $di->set('config', $dbConfig);

        $di->set('db',function () use($dbConfig){
            return new \Phalcon\Db\Adapter\Pdo\Mysql([
                'host' => $dbConfig->database->host,
                'username' => $dbConfig->database->username,
                'password' => $dbConfig->database->password,
                'dbname' => $dbConfig->database->dbname,
                'options' => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
                    \PDO::ATTR_EMULATE_PREPARES=>false,
                    \PDO::ATTR_STRINGIFY_FETCHES=>false
                ]
            ]);
        },true);


        $di->set('response',function (){
            return new Response();
        });


        $di->set('view', function () {

            $view = new View();


            return $view;
        });

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }

}
