<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/3/2017
 * Time: 4:41 PM
 */

namespace Models;


trait WalletTrait
{

    private $coins= [];



    function getAvailableCoins(): array
    {
        return $this->coins;
    }

    function getData()
    {
        $ones = new Coin(1);
        $ones->quantity= $this->getOneRub();

        $twos = new Coin(2);
        $twos->quantity= $this->getTwoRub();

        $fives = new Coin(5);
        $fives->quantity = $this->getFiveRub();

        $tens = new Coin(10);
        $tens->quantity = $this->getTenRub();

        $this->coins[Coin::ONE_RUB] = $ones;
        $this->coins[Coin::TWO_RUB] = $twos;
        $this->coins[Coin::FIVE_RUB] = $fives;
        $this->coins[Coin::TEN_RUB] = $tens;
    }


}