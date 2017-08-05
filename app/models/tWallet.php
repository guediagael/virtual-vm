<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/3/2017
 * Time: 4:41 PM
 */

namespace Wallet;


trait TWallet
{

    private $coins= [];

    function insertMoney(Coin $coin)
    {
        $var = $this->coins[$coin->getValue()];
        $var++;
        $this->coins[$coin->getValue()] = $var;
    }

    function retrieveMoney(Coin $coin)
    {
        $var = $this->coins[$coin->getValue()];
        $var--;
        $this->coins[$coin->getValue()] = $var;
        return $var;
    }

    function getAvailableCoins(): array
    {
        return $this->coins;
    }


}