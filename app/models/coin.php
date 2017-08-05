<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/2/2017
 * Time: 6:07 PM
 */

namespace Wallet;



class Coin
{

    const ONE_RUB = 1;
    const TWO_RUB = 2;
    const FIVE_RUB = 5;
    const TEN_RUB = 10;

    public $value;
    public $imageUrl;
    public $quantity;

    /**
     * Coin constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }


    private function setValue($val){
        switch ($val){
            case self::ONE_RUB:
                $this->value = 1;
                $this->imageUrl = 'public/img/oneRuble.png';
                break;
            case self::TWO_RUB:
                $this->value=2;
                $this->imageUrl = 'public/img/twoRubles.png';
                break;
            case self::FIVE_RUB:
                $this->value = 5;
                $this->imageUrl = 'public/img/fiveRubles.png';
                break;
            case self::TEN_RUB:
                $this->value = 10;
                $this->imageUrl = 'public/img/tenRubles.png';
                break;
            default : throw  new \Exception("Не существует такого достоинства");
            break;
        }
    }

    public function getValue(): int{
        return $this->value;
    }





}