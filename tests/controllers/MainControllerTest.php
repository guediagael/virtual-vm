<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/11/2017
 * Time: 7:25 PM
 */

namespace TestControllers;


use MainController;
class MainControllerTest extends MainControllerPhalconTest
{
    protected static $controller;

    public function setUp()
    {
        parent::setUp();

        self::$controller->resetAction();

    }


    public static function setUpBeforeClass()
    {

        parent::setUpBeforeClass();
        self::$controller = new MainController();

    }

    /**
     * @dataProvider coinProvider
     */
    public function testCoinInserted($insertedCoinValue)
    {
        $initialBalance = self::$controller->getBalance();
        $initialCustomerSum = self::$controller->getCustomerSum();

        self::$controller->coinInsertedAction($insertedCoinValue);

        $expectedBalance = $initialBalance + $insertedCoinValue;
        $expectedCustomerSum = $initialCustomerSum - $insertedCoinValue;

        $actualBalance = self::$controller->getBalance();
        $actualCustomerSum = self::$controller->getCustomerSum();

        self::assertEquals($expectedCustomerSum,$actualCustomerSum);
        self::assertEquals($expectedBalance,$actualBalance);


    }

    /**
     * @dataProvider idAndMoneyProvider
     */
    public function testBuyProduct($id, $insertedCoin1, $insertedCoin2=null,$insertedCoin3=null,$insertedCoin4=null)
    {
        $argList = func_get_args();

        for ($i =1; $i<func_num_args(); $i++)
        {
            if ($i!=null || $i >0) self::$controller->coinInsertedAction($argList[$i]);
        }
        $initialBalance = self::$controller->getBalance();
        $status = self::$controller->productSelectedAction($id);
        $finalBalance = self::$controller->getBalance();

        if ($status['isSelectionValidated'])
        {
            self::assertGreaterThan($finalBalance,$initialBalance);
        }
        else
        {
            self::assertEquals($initialBalance,$finalBalance);
        }


    }

    /**
     * @dataProvider changeCoinProvider
     */
    public function testGetChange($insertedCoin)
    {


        $initialCustomerSum = self::$controller->getCustomerSum();

        self::$controller->coinInsertedAction($insertedCoin);
        $initialBalance = self::$controller->getBalance();
        $initialVendingSum = self::$controller->getMachineSum();
        self::$controller->getChangeAction();

        $expectedMachineSum = $initialVendingSum-$initialBalance;

        $finalCustomerSum = self::$controller->getCustomerSum();
        $finalMachineSum = self::$controller->getMachineSum();

        self::assertEquals($initialCustomerSum,$finalCustomerSum);
        self::assertEquals($expectedMachineSum,$finalMachineSum);

    }


    public static function idAndMoneyProvider()
    {
        return [
            'buy tea with enough money'  => [1,10,5],
            'buy tea with not enough money'  => [1,10,1],
            'buy Coffee with enough money' => [2,10,10],
            'buy Coffee with not enough money' => [2,10,5],
            'buy white coffee with enough money' => [3,10,10,1],
            'buy white coffee with not enough money' => [3,10],
            'buy juice with enough money' => [4,10,10,10,5],
            'buy juice with not enough money'  => [4,10]
        ];

    }



    public static function coinProvider()
    {
        return[
            'one ruble' =>[1],
            'two rubles' =>[2],
            'five rubles' =>[5],
            'ten rubles' =>[10]
        ];
    }


    public static function changeCoinProvider()
    {
        return[
            'change for one rub' =>[1],
            'change for two rub' =>[2],
            'change for five rub' =>[5],
            'change for ten rub' =>[10]

        ];
    }




}
