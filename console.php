<?php

require_once __DIR__ . '/vendor/autoload.php';

use Command\PurchaseCommand;
use Symfony\Component\Console\Application;

$app = new Application('Purchase Console App', 'v1.0.0');
$app -> add(new PurchaseCommand());
$app -> run();
