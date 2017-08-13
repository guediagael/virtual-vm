<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/11/2017
 * Time: 7:26 PM
 */

namespace Models\Utils;

use PHPUnit\Framework\TestCase;
use Models\Coin;

class CoinSortTest extends TestCase
{
    public function testSortForTen()
    {
        $coinSort = new CoinSort(10,5,2,1);

        $expectedChange = [
            Coin::TEN_RUB =>1,
            Coin::FIVE_RUB =>0,
            Coin::TWO_RUB =>0,
            Coin::ONE_RUB =>0
        ];

        $realChange = $coinSort->sort(10);
        self::assertSame($expectedChange,$realChange);
    }

    public function testSortForFive()
    {
        $coinSort = new CoinSort(5,3,1,1);

        $expectedChange = [
            Coin::TEN_RUB =>0,
            Coin::FIVE_RUB =>1,
            Coin::TWO_RUB =>0,
            Coin::ONE_RUB =>0
        ];

        $realChange = $coinSort->sort(5);


        self::assertSame($expectedChange,$realChange);
    }

    public function testSortForTwo()
    {
        $coinSort = new CoinSort(2,1,1,1);

        $expectedChange = [
            Coin::TEN_RUB =>0,
            Coin::FIVE_RUB =>0,
            Coin::TWO_RUB =>1,
            Coin::ONE_RUB =>0
        ];

        $realChange = $coinSort->sort(2);

        self::assertSame($expectedChange,$realChange);
    }

    public function testSortForOne()
    {
        $coinSort = new CoinSort(1,1,1,1);
//        $initialBalance = $coinSort->getBalance();
        $expectedChange = [
            Coin::TEN_RUB =>0,
            Coin::FIVE_RUB =>0,
            Coin::TWO_RUB =>0,
            Coin::ONE_RUB =>1
        ];

        $realChange = $coinSort->sort(1);
//        $balanceAfterChange = $coinSort->getBalance();
        self::assertSame($expectedChange,$realChange);
//        self::assertGreaterThan($initialBalance,$balanceAfterChange);
    }
}
