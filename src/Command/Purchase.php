<?php

namespace Command;

use Machine\MachineFactory;
use Machine\MachineType\CigaretteMachine;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PurchaseCommand extends SymfonyCommand
{
    /** @var  SymfonyStyle */
    private $io;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('limangorec:machine')
            ->setDescription('Buy product.')
            ->setHelp('
                The main purpose of the command is to buy product from a machine.
            ')
            ->addArgument('cmd', InputArgument::REQUIRED, 'Enter a command.')
            ->addOption('product', 'p', InputOption::VALUE_REQUIRED, 'Product name')
            ->addOption('amount', 'a', InputOption::VALUE_REQUIRED, "Amount of product")
            ->addOption('money', 'm', InputOption::VALUE_REQUIRED, 'Money');
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $cmd = (string)$input->getArgument("cmd");

        switch ($cmd) {
            case 'purchase':
                if (!$this->purchase($input,  $output)) {
                    return;
                };
                break;
        }
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    private function purchase(InputInterface $input, OutputInterface $output)
    {
        if (
            (!$product = (string)$input->getOption('product'))
            || (!$amount = (int)$input->getOption('amount'))
            || (!$money = (float)$input->getOption('money'))
        ){
            $this->io->error('Please, enter: product, amount, money');
            return false;
        }

        $productObj = MachineFactory::createMachine($product);

        if (!$productObj
            ->setAmountProduct($amount)
            ->setMoney($money)->
            buy()) {
            $this->io->error('Not enough money!');
            return false;
        };

        $this->io->title(
            "You bought " . (string)$amount
            . " packs of cigarettes for -" . (string)$productObj->getPurchaseSum()
            . "€" . " ,each for -4,99€."
        );

        $table = new Table($output);
        $table
            ->setHeaders(['Coins', 'Count'])
            ->setRows($productObj->getChange());

        if ($productObj->getChange()) {
            $this->io->writeln('Your change is:');
            $table->render();
        }

        $this->io->writeln("Thank you for your purchase! Good luck!");
    }
}