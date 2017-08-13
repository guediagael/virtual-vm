<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/3/2017
 * Time: 4:41 PM
 */

namespace Models;


trait TWallet
{

    private $coins= [];



    function getAvailableCoins(): array
    {
        return $this->coins;
    }


}