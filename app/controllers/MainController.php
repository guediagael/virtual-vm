<?php

use Models\ClientWallet as Client;
use Models\VmWallet as VendingWallet;
use Models\Coin as Coin;
use Models\Utils\CoinSort as CoinSort;

class MainController extends \Phalcon\Mvc\Controller
{
    private $baseUrl ='http://localhost/virtual-vm';

    private $customerBalance = 0;
    private $vmCache = 0;
    private $vmBalance = 0;

    private $customerWallet;
    private $vendingWallet;

    private $customerCoins;
    private $vendingMachineCoins;

    private $message= ' ';
    private $products;


    public function indexAction()
    {

        $this->getCustomerInfo();

        $this->getMachineInfo();
        $this->view->setVar('message',$this->message);
    }



   public function balanceInfoAction(){
        $this->view->setVar('clientBalance' ,50);
        $this->view->getVar('clientBalance');
   }

   public function coinInsertedAction(int $value){
       $this->customerWallet = Client::findFirst();
       $this->vendingWallet = VendingWallet::findFirst();

       $balance = $this->vendingWallet->getBalance();
       $balance+=$value;
       $this->vendingWallet->setBalance($balance);
       $this->vendingWallet->save();

       switch ($value){
           case 1:
              $ones =$this->customerWallet->getOneRub();
              $ones--;
              $this->customerWallet->setOneRub($ones);
              if ($this->customerWallet->save())
              {
                  $ones = $this->vendingWallet->getOneRub();
                  $ones++;
                  $this->vendingWallet->setOneRub($ones);
                  $this->vendingWallet->save();


              }
               break;
           case 2:
               $twos =$this->customerWallet->getTwoRub();
               $twos--;
               $this->customerWallet->setTwoRub($twos);
               if ($this->customerWallet->save())
               {
                   $twos = $this->vendingWallet->getTwoRub();
                   $twos++;
                   $this->vendingWallet->setTwoRub($twos);
                   $this->vendingWallet->save();

               }
               break;
           case 5:
               $five =$this->customerWallet->getFiveRub();
               $five--;
               $this->customerWallet->setFiveRub($five);
               if ($this->customerWallet->save())
               {
                   $five = $this->vendingWallet->getFiveRub();
                   $five++;
                   $this->vendingWallet->setFiveRub($five);
                   $this->vendingWallet->save();
               }
               break;
           case 10:
               $ten =$this->customerWallet->getTenRub();
               $ten--;
               $this->customerWallet->setTenRub($ten);
               if ($this->customerWallet->save())
               {
                   $ten = $this->vendingWallet->getTenRub();
                   $ten++;
                   $this->vendingWallet->setTenRub($ten);
                   $this->vendingWallet->save();
               }
               break;


       }

       $this->view->setVar('message','');
       $this->getCustomerInfo();
       $this->getMachineInfo();


   }


   public function getChangeAction(){
       $machine=VendingWallet::findFirst();
       $oldBalance = $machine->getBalance();

       $customer = Client::findFirst();
       $customerOnes= $customer->getOneRub();
       $customerTwos = $customer->getTwoRub();
       $customerFives = $customer->getFiveRub();
       $customerTens = $customer->getTenRub();

       $availableBalance = 0;

       if ($oldBalance>0)
       {
           $oldOnes = $machine->getOneRub();


           $oldTwos = $machine->getTwoRub();

           $oldFives = $machine->getFiveRub();
           $oldTens = $machine->getTenRub();


           $sorter = new CoinSort($oldOnes,$oldTwos,$oldFives,$oldTens);
           $change = $sorter->sort($oldBalance);

           $availableBalance = $sorter->getBalance();

           $availableOnes = $change[Coin::ONE_RUB];
           $availableTwos = $change[Coin::TWO_RUB];
           $availableFives = $change[Coin::FIVE_RUB];
           $availableTens = $change[Coin::TEN_RUB];

           $customerOnes +=$availableOnes;
           $customerTwos +=$availableTwos;
           $customerFives += $availableFives;
           $customerTens += $availableTens;

           $customer->setOneRub($customerOnes);
           $customer->setTwoRub($customerTwos);
           $customer->setFiveRub($customerFives);
           $customer->setTenRub($customerTens);
           $customer->save();

           $finalOnes = $oldOnes-$availableOnes;
           $finalTwos = $oldTwos - $availableTwos;
           $finalFives = $oldFives - $availableFives;
           $finalTens = $oldTens - $availableTens;



           $machine->setBalance($availableBalance);
           $machine->setOneRub($finalOnes);
           $machine->setTwoRub($finalTwos);
           $machine->setFiveRub($finalFives);
           $machine->setTenRub($finalTens);

           $machine->save();
       }



       $this->getCustomerInfo();
       $this->getMachineInfo();

//       $this->view->setVar('vmCache',$availableBalance);
       $this->view->setVar('message','');
   }


   public function resetAction(){
       $this->vendingWallet = VendingWallet::findFirst();
       $this->vendingWallet->setTenRub(100);
       $this->vendingWallet->setFiveRub(100);
       $this->vendingWallet->setTwoRub(100);
       $this->vendingWallet->setOneRub(100);
       $this->vendingWallet->setBalance(0);
       $this->vendingWallet->save();

       $this->customerWallet = Client::findFirst();
       $this->customerWallet->setOneRub(10);
       $this->customerWallet->setTwoRub(30);
       $this->customerWallet->setFiveRub(20);
       $this->customerWallet->setTenRub(15);
       $this->customerWallet->save();

       $this->view->setVar('message','');
       $this->getCustomerInfo();
       $this->getMachineInfo();

   }

   public function productSelectedAction($id){
       $product = Product::findFirst($id);

       $price = $product->getPrice();

       $machine = VendingWallet::findFirst();

       $this->vmCache = $machine->getBalance();

       if ($price<=$this->vmCache)
       {
           $newBalance = $this->vmCache - $price;
           $machine->setBalance($newBalance);
           $machine->save();
           $this->view->setVar('message','продукт выдан');
       }
       else
       {
           $this->view->setVar('message','не достаточно срество');
       }
       $this->getMachineInfo();
       $this->getCustomerInfo();
   }

   private function getBalance(&$coins ): int{
       $ones = $coins[Coin::ONE_RUB]->quantity;
       $twos = $coins[Coin::TWO_RUB]->quantity * 2;
       $fives = $coins[Coin::FIVE_RUB]->quantity * 5;
       $tens = $coins[Coin::TEN_RUB]->quantity * 10;

       return $ones + $twos + $fives + $tens;

   }




   private function getCustomerInfo(){
       $this->view->setVar('baseUrl',$this->baseUrl);
       $this->customerWallet = Client::findFirst();
       $this->customerWallet->getData();
       $this->customerCoins= $this->customerWallet->getAvailableCoins();

       $this->customerBalance = $this->getBalance($this->customerCoins);
       $this->view->setVar('coins',$this->customerCoins);
       $this->view->setVar('customerBalance' ,$this->customerBalance);
   }



   private function getMachineInfo(){
       $this->vendingWallet = VendingWallet::findFirst();
       $this->vendingWallet->getData();
       $this->vendingMachineCoins = $this->vendingWallet->getAvailableCoins();


       $this->vmBalance = $this->getBalance($this->vendingMachineCoins);
       $this->vmCache =$this->vendingWallet->getBalance();
       $this->products = Product::find();

       $this->view->setVar('vmBalance' , $this->vmBalance);
       $this->view->setVar('vmCache' ,$this->vmCache);
       $this->view->setVar('products',$this->products);
       $this->view->setVar('vendingCoins', $this->vendingMachineCoins);


   }









}

