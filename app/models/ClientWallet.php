<?php

namespace Models;

class ClientWallet extends \Phalcon\Mvc\Model implements \Wallet
{
    use \Models\TWallet;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $one_rub;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $two_rub;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $five_rub;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $ten_rub;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field one_rub
     *
     * @param integer $one_rub
     * @return $this
     */
    public function setOneRub($one_rub)
    {
        $this->one_rub = $one_rub;

        return $this;
    }

    /**
     * Method to set the value of field two_rub
     *
     * @param integer $two_rub
     * @return $this
     */
    public function setTwoRub($two_rub)
    {
        $this->two_rub = $two_rub;

        return $this;
    }

    /**
     * Method to set the value of field five_rub
     *
     * @param integer $five_rub
     * @return $this
     */
    public function setFiveRub($five_rub)
    {
        $this->five_rub = $five_rub;

        return $this;
    }

    /**
     * Method to set the value of field ten_rub
     *
     * @param integer $ten_rub
     * @return $this
     */
    public function setTenRub($ten_rub)
    {
        $this->ten_rub = $ten_rub;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field one_rub
     *
     * @return integer
     */
    public function getOneRub()
    {
        return $this->one_rub;
    }

    /**
     * Returns the value of field two_rub
     *
     * @return integer
     */
    public function getTwoRub()
    {
        return $this->two_rub;
    }

    /**
     * Returns the value of field five_rub
     *
     * @return integer
     */
    public function getFiveRub()
    {
        return $this->five_rub;
    }

    /**
     * Returns the value of field ten_rub
     *
     * @return integer
     */
    public function getTenRub()
    {
        return $this->ten_rub;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'client_wallet';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientWallet[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientWallet
     */
    public static function findFirst($parameters = null)
    {

        return parent::findFirst($parameters);
    }

    function getData()
    {
        $ones = new Coin(1);
        $ones->quantity = $this->getOneRub();

        $twos = new Coin(2);
        $twos->quantity = $this->getTwoRub();

        $fives = new Coin(5);
        $fives->quantity = $this->getFiveRub();

        $tens = new Coin(10);
        $tens->quantity = $this->getTenRub();

        $this->coins[Coin::ONE_RUB] = $ones;
        $this->coins[Coin::TWO_RUB] = $twos;
        $this->coins[Coin::FIVE_RUB] = $fives;
        $this->coins[Coin::TEN_RUB] = $tens;
    }
}
