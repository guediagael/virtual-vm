<?php


class MainController extends \Phalcon\Mvc\Controller
{

    private $clientBalance = 100;
    private $vmCache = 5000;
    private $vmBalance = 0;




    public function indexAction()
    {

        $this->view->setVar('clientBalance' ,$this->clientBalance);
        $this->view->setVar('vmCache' ,$this->vmCache);
        $this->view->setVar('vmBalance' , $this->vmBalance);
    }



   public function balanceInfoAction(){
        $this->view->setVar('clientBalance' ,50);
        $this->flash->notice("Nothing inserted");
        $this->view->getVar('clientBalance');
   }

   public function customerInfoAction(){
       $this->flash->notice("This is your money");
   }

   public function machineInfoAction(){
       $this->flash->notice("This is the vending machine");
   }




}

