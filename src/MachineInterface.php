<?php

namespace Machine;

interface MachineInterface
{
    public function setMoney($eur);

    public function setAmountProduct($product);

    public function buy();

    public function calculateChangeInCoins();
}