<?php

namespace Wallet;

class VmWallet extends \Phalcon\Mvc\Model implements \Wallet
{
    use \Wallet\TWallet;

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
        return 'vm_wallet';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VmWallet[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VmWallet
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    function getData()
    {
        $this->coins[Coin::ONE_RUB] = $this->getOneRub();
        $this->coins[Coin::TWO_RUB] = $this->getTwoRub();
        $this->coins[Coin::FIVE_RUB] = $this->getFiveRub();
        $this->coins[Coin::TEN_RUB] = $this->getTenRub();
    }
}
