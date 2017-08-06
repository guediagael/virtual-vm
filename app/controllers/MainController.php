<?php

use Wallet\ClientWallet as Client;
use Wallet\VmWallet as VendingWallet;
use Wallet\Coin as Coin;

class MainController extends \Phalcon\Mvc\Controller
{
    private $baseUrl ='http://localhost/virtual-vm';

    private $customerBalance = 0;
    private $vmCache = 15;
    private $vmBalance = 0;

    private $customerWallet;
    private $vendingWallet;
    private $vendingCache;

    private $customerCoins;
    private $vendingMachineCoins;
    private $cacheCoins;

    private $message= ' ';
    private $products;


    public function indexAction()
    {

        $this->getCustomerInfo();

        $this->getMachineInfo();
        $this->view->setVar('vmCache' ,$this->vmCache);
        $this->view->setVar('message',$this->message);
    }



   public function balanceInfoAction(){
        $this->view->setVar('clientBalance' ,50);
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

       $this->view->setVar('message','');
       $this->getCustomerInfo();
       $this->getMachineInfo();


   }


   public function getBalanceAction(){
       $this->view->setVar('vmCache',$this->vmCache);
       $this->view->setVar('message','');
       $this->getCustomerInfo();
       $this->getMachineInfo();
   }


   public function productSelectedAction($id){
       $product = Product::findFirst($id);
       $price = $product->getPrice();
       if ($price<=$this->vmCache)
       {
           $this->view->setVar('message','bought');
       }
       else
       {
           $this->view->setVar('message','not enought money');
       }
       $this->getCustomerInfo();
       $this->getMachineInfo();
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
       $this->view->setVar('baseUrl',$this->baseUrl);
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
       $this->products = Product::find();

       $this->view->setVar('vmBalance' , $this->vmBalance);
       $this->view->setVar('vmCache' ,$this->vmCache);
       $this->view->setVar('products',$this->products);


   }






}

