<?php

use Wallet\ClientWallet as Client;
use Wallet\VmWallet as VendingWallet;
use Wallet\Coin as Coin;
class MainController extends \Phalcon\Mvc\Controller
{

    private $customerBalance = 0;
    private $vmCache = 0;
    private $vmBalance = 0;

    private $customerWallet;
    private $vendingWallet;
    private $vendingCache;

    private $customerCoins;
    private $vendingMachineCoins;
    private $cacheCoins;


    public function indexAction()
    {

        $this->getCustomerInfo();

        $this->getMachineInfo();
        $this->view->setVar('vmCache' ,$this->vmCache);
    }



   public function balanceInfoAction(){
        $this->view->setVar('clientBalance' ,50);
//        $this->flash->notice("Nothing inserted");
        $this->view->getVar('clientBalance');
   }

   public function coinInsertedAction(int $value){


       switch ($value){
           case 1:
               $this->customerCoins[Coin::ONE_RUB]--;
//           TODO: save to db
               break;
           case 2:
               $this->customerCoins[Coin::TWO_RUB]--;
               break;
           case 5:
               $this->customerCoins[Coin::FIVE_RUB]--;
               break;
           case 10:
               $this->customerCoins[Coin::TEN_RUB]--;
               break;


       }

       $this->getCustomerInfo();
       $this->getMachineInfo();


   }

   public function machineInfoAction(){
       $this->flash->notice("This is the vending machine");
   }




   private function getBalance(&$coins ): int{
       $ones = $coins[Coin::ONE_RUB];
       $twos = $coins[Coin::TWO_RUB] * 2;
       $fives = $coins[Coin::FIVE_RUB] * 5;
       $tens = $coins[Coin::TEN_RUB] * 10;

       return $ones + $twos + $fives + $tens;

   }

   private function getCoins(&$coins): array {
       $ones = new Coin(1);
       $ones->quantity = $coins[Coin::ONE_RUB];

       $twos = new Coin(2);
       $twos->quantity = $coins[Coin::TWO_RUB];

       $fives = new Coin(5);
       $fives->quantity = $coins[Coin::FIVE_RUB];

       $tens = new Coin(10);
       $tens->quantity = $coins[Coin::TEN_RUB];

       return  [$ones,$twos,$fives,$tens];

   }



   private function getCustomerInfo(){
       $this->customerWallet = Client::findFirst();
       $this->customerWallet->getData();
       $this->customerCoins= $this->customerWallet->getAvailableCoins();

       $this->customerBalance = $this->getBalance($this->customerCoins);
       $this->view->setVar('coins',$this->getCoins($this->customerCoins));
       $this->view->setVar('customerBalance' ,$this->customerBalance);
   }



   private function getMachineInfo(){
       $this->vendingWallet = VendingWallet::findFirst();
       $this->vendingWallet->getData();
       $this->vendingMachineCoins = $this->vendingWallet->getAvailableCoins();

       $this->vmBalance = $this->getBalance($this->vendingMachineCoins);

       $this->view->setVar('vmBalance' , $this->vmBalance);
       $this->view->setVar('vmCache' ,$this->vmCache);


   }






}

