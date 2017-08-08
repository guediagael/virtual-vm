<?php
/**
 * Created by PhpStorm.
 * User: guedi
 * Date: 8/6/2017
 * Time: 2:52 PM
 */
namespace Utils;
use Wallet\Coin as Coin;
class CoinSort
{
    private $initialBalance;
    private $change;

    private $availableOnes = 0;
    private $availableTwos = 0;
    private $availableFives  = 0;
    private $availableTens = 0;

    private $ones = 0;
    private $twos = 0;
    private $fives = 0;
    private $tens = 0;

    /**
     * CoinSort constructor.
     */
    public function __construct($availableOnes, $availableTwos, $availableFives,$availableTens)
    {
        $this->availableOnes = $availableOnes;
        $this->availableTwos = $availableTwos;
        $this->availableFives = $availableFives;
        $this->availableTens  = $availableTens;
    }


    public  function sort($balance):array
    {
        $this->initialBalance = $balance;
        if ($this->initialBalance >=10 )
        {
            $this->getTens();
        }
        if ($this->initialBalance <10 && $this->initialBalance >=5)
        {
            $this->getFives();
        }
        if ($this->initialBalance <5 && $this->initialBalance >=2)
        {
            $this->getTwos();
        }
        if ($this->initialBalance<2 && $this->initialBalance>0)
        {
           $this->getOnes();
        }

        $this->change = [
            Coin::TEN_RUB =>$this->tens,
            Coin::FIVE_RUB =>$this->fives,
            Coin::TWO_RUB =>$this->twos,
            Coin::ONE_RUB =>$this->ones
        ];

       return $this->change;
    }


    private function getTens()
    {
        while($this->initialBalance>=10)
        {
            if ($this->availableTens>0)
            {

                $minus = -10;
                $this->initialBalance+=$minus;
                $this->availableTens--;
                $this->tens++;
            }
            else
            {
                $this->getFives();
            }
        }
    }

    private function getFives()
    {
        if ($this->availableFives >0)
        {
            $minus = -5;
            $this->initialBalance+=$minus;
            $this->availableFives--;
            $this->fives++;
        }
        else
        {
            while ($this->initialBalance >=2)
            {
                $this->getTwos();
            }

        }

    }

    private function getTwos()
    {
        if ($this-$this->availableTwos>0)
        {
            $minus = -2;
            $this->initialBalance+=$minus;
            $this->availableTwos--;
            $this->twos++;
        }
        else
        {
            while ($this->initialBalance>=1)
            {
                $this->getOnes();
            }

        }
    }


//    если даже монеты одного рублей нет то автомат ничего не выдаст
    private function getOnes()
    {
        if ($this->availableOnes>0)
        {
            $this->initialBalance--;
            $this->availableOnes--;
            $this->ones++;
        }

    }

    public function getBalance(): int
    {
        return $this->initialBalance;
    }


}