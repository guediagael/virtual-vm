<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/2/2017
 * Time: 6:07 PM
 */

namespace Wallet;


use \Model;

class Coin implements Model
{

    const ONE_RUB = 1;
    const TWO_RUB = 2;
    const FIVE_RUB = 5;
    const TEN_RUB = 10;

    private $value;

    public function setValue($val){
        switch ($val){
            case self::ONE_RUB:
                $this->value = 1;
                break;
            case self::TWO_RUB:
                $this->value=2;
                break;
            case self::FIVE_RUB:
                $this->value = 5;
                break;
            case self::TEN_RUB:
                $this->value = 10;
                break;
            default : throw  new \Exception("Не существует такого достоинства");
            break;
        }
    }

    public function getValue(): int{
        return $this->value;
    }


    function getData()
    {
        // TODO: Implement getData() method.
    }
}