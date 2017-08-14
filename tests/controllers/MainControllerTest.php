<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/11/2017
 * Time: 7:25 PM
 */

namespace TestControllers;

use PHPUnit\Framework\TestCase;
use Phalcon\Di;
use Phalcon\Config;
use Phalcon\Test\UnitTestCase as PhalconTestCase;
use MainController;
class MainControllerTest extends MainControllerPhalconTest
{
//    protected static $di;
    protected static $controller;
    protected static $vmBalance;
    protected static $customerInitialSum;
    protected static $vendingInitialSum;

    public function setUp()
    {
        parent::setUp();



        self::$controller = new MainController();
        self::$vmBalance = self::$controller->getBalance();
        self::$vendingInitialSum = self::$controller->getMachineSum();
        self::$customerInitialSum = self::$controller->getCustomerSum();
    }

    public static function setUpBeforeClass()
    {


    }

    public function testCoinInserted()
    {
        $insertedCoinValue = 5;
        self::$controller->coinInsertedAction($insertedCoinValue);
        $expectedNewBalance = self::$vmBalance + $insertedCoinValue;
        $expectedNewCustomerSum = self::$customerInitialSum - $insertedCoinValue;
        $actualBalance = self::$controller->getBalance();
        $actualCustomerSum = self::$controller->getCustomerSum();
        self::assertSame($expectedNewCustomerSum,$actualCustomerSum);
        self::assertSame($expectedNewBalance,$actualBalance);


    }
}
