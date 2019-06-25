<?php

namespace Machine;

interface MachineInterface
{
    public function getMoney();

    public function setMoney($eur);

    public function setAmountProduct($product);

    public function getAmountProduct();

    public function buy();
}