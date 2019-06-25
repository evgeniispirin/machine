<?php

namespace Machine\MachineType;

use Machine\MachineInterface;

class CigaretteMachine implements MachineInterface
{
    const CIGARETTE_PRICE = 4.99;

    private $money;
    private $amountProduct;
    private $change = [];
    private $purchasedProduct;
    private $restMoney;

    public function __construct($money = 0,$amountProduct = 0)
    {
        $this->money = $money;
        $this->amountProduct = $amountProduct;
    }

    public function buy()
    {
        $this->purchasedProduct = round($this->money / self::CIGARETTE_PRICE);

        if($this->purchasedProduct < 1 || ($this->money < self::CIGARETTE_PRICE * $this->amountProduct)){
            echo 'Not enough money!';
            die();
        }

        $this->restMoney = $this->money - (self::CIGARETTE_PRICE * $this->amountProduct);
        $this->calculateChangeInCoins();
    }

    public function calculateChangeInCoins()
    {
        $coinsAvailable = [
            'Fifty cent'  => 0.50,
            'Twenty cent' => 0.20,
            'Ten cent'    => 0.10,
            'Five cent'   => 0.05,
            'Two cent'    => 0.02,
            'One cent'    => 0.01
        ];

        foreach ($coinsAvailable as $coinName => $value) {
            $coins = number_format($this->restMoney / $value);

            if ($coins > 0) {
                $this->change[$coinName] = ($coins > 0) ? $coins : 0;
                $this->restMoney -= ($value * $coins);
            }
        }
    }

    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    public function setAmountProduct($amountProduct)
    {
        $this->amountProduct = $amountProduct;

        return $this;
    }

    public function getChange()
    {
        return $this->change;
    }
}