<?php


use Models\ClientWallet as Client;
use Models\VmWallet as VendingWallet;
use Models\Coin as Coin;
use Models\Utils\CoinSort as CoinSort;
use Models\Product;

class MainController extends \Phalcon\Mvc\Controller
{
    private $baseUrl ='http://localhost/virtual-vm';
    private $vmBalance = 0;
    private $customerWallet;
    private $vendingWallet;
    private $customerCoins;
    private $vendingMachineCoins;
    private $products;

    public function indexAction($message=null)
    {

        $this->view->setVar('message',$message);
        $this->getCustomerInfo();

        $this->getMachineInfo();
    }

    public function coinInsertedAction(int $value)
   {

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

       $this->getCustomerInfo();
       $this->getMachineInfo();

       $this->refreshPage(null);


   }

   public function getChangeAction()
   {
       $machine=VendingWallet::findFirst();
       $oldBalance = $machine->getBalance();

       $customer = Client::findFirst();
       $customerOnes= $customer->getOneRub();
       $customerTwos = $customer->getTwoRub();
       $customerFives = $customer->getFiveRub();
       $customerTens = $customer->getTenRub();


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


       $this->refreshPage(null);
   }

   public function resetAction()
   {
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

       $availableProducts = new Product();
       $this->products = $availableProducts->getData();

       foreach ($this->products as $product)
       {
           switch ($product->getName())
           {
               case 'tea' :
                   $product->setQuantity(10);
                   $product->save();
                   break;
               case 'Coffee' :
                   $product->setQuantity(20);
                   $product->save();
                   break;
               case 'white coffee' :
                   $product->setQuantity(20);
                   $product->save();
                   break;
               case 'juice' :
                   $product->setQuantity(15);
                   $product->save();
                   break;
           }
       }


       $this->getCustomerInfo();
       $this->getMachineInfo();

      $this->refreshPage(null);

   }

   public function productSelectedAction($id)
   {
       $isSelectionValidated = false;

       $product = Product::findFirst($id);

       $price = $product->getPrice();

       $quantity = $product->getQuantity();

       $machine = VendingWallet::findFirst();

       $this->vmBalance = $machine->getBalance();

       if ($price<=$this->vmBalance && $quantity>0)
       {
           $newBalance = $this->vmBalance - $price;
           $machine->setBalance($newBalance);
           $machine->save();

           $quantity--;
           $product->setQuantity($quantity);
           $product->save();

           $message = 'продукт выдан';
           $isSelectionValidated = true;


       }
       elseif ($quantity==0)
       {
           $message = 'продукт закончен';
       }
       else
       {
           $message = 'не достаточно срество';
       }
       $this->getMachineInfo();
       $this->getCustomerInfo();
       $this->refreshPage($message);

       return [
           'isSelectionValidated' => $isSelectionValidated,
           'message' => $message
       ];
   }

   public function getCustomerSum():int
   {
       $this->customerWallet = Client::findFirst();
       $this->customerWallet->getData();
       $this->customerCoins= $this->customerWallet->getAvailableCoins();

       return $this->getSumFromCoins($this->customerCoins);
   }

   public function getMachineSum():int
   {
       $this->vendingWallet = VendingWallet::findFirst();
       $this->vendingWallet->getData();
       $this->vendingMachineCoins = $this->vendingWallet->getAvailableCoins();

       $this->vmBalance =$this->vendingWallet->getBalance();

       return $this->getSumFromCoins($this->vendingMachineCoins);
   }

   public function getBalance(): int
   {
       return $this->vmBalance;
   }

   private function getSumFromCoins(&$coins ): int
   {
       $ones = $coins[Coin::ONE_RUB]->quantity;
       $twos = $coins[Coin::TWO_RUB]->quantity ;
       $fives = $coins[Coin::FIVE_RUB]->quantity ;
       $tens = $coins[Coin::TEN_RUB]->quantity ;

       return $ones + $twos * 2 + $fives * 5 + $tens * 10;

   }

   private function getCustomerInfo()
   {
       $this->view->setVar('baseUrl',$this->baseUrl);
       $this->view->setVar('customerBalance' ,$this->getCustomerSum());
       $this->view->setVar('coins',$this->customerCoins);


   }

   private function getMachineInfo()
   {
       $this->products = Product::find();
       $this->view->setVar('vmSum' , $this->getMachineSum());
       $this->view->setVar('vmBalance' ,$this->vmBalance);
       $this->view->setVar('products',$this->products);
       $this->view->setVar('vendingCoins', $this->vendingMachineCoins);


   }

   private function refreshPage($message)
   {
       $this->response->redirect('/main/index/'. $message);
       $this->view->disable();


   }

}

