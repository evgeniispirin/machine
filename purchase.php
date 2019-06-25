<?php

namespace Machine;

require_once 'vendor/autoload.php';

$product = (string)$argv[1];
$amountProduct = (int)$argv[2];
$money = (float)$argv[3];

if (!$product) {
    echo 'Please enter a product.';
    die;
} elseif (!$amountProduct) {
    echo 'Please enter amount of a product.';
    die;
} elseif (!$money) {
    echo 'Please put your money into the machine.';
    die;
}

$productObj = MachineFactory::createMachine($product);

$productObj
    ->setAmountProduct($amountProduct)
    ->setMoney($money)->
    buy();


var_dump($productObj->getChange());
