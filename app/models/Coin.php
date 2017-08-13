<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/2/2017
 * Time: 6:07 PM
 */

namespace Models;



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
                $this->imageUrl = 'https://en.numista.com/catalogue/photos/russie/g32.jpg';
                break;
            case self::TWO_RUB:
                $this->value=2;
                $this->imageUrl = 'https://en.numista.com/catalogue/photos/russie/g30.jpg';
                break;
            case self::FIVE_RUB:
                $this->value = 5;
                $this->imageUrl = 'https://en.numista.com/catalogue/photos/russie/g66.jpg';
                break;
            case self::TEN_RUB:
                $this->value = 10;
                $this->imageUrl = 'https://en.numista.com/catalogue/photos/russie/g5849.jpg';
                break;
            default : throw  new \Exception("Не существует такого достоинства");
            break;
        }
    }

    public function getValue(): int{
        return $this->value;
    }





}