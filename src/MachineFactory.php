<?php

namespace Machine;

use Machine\MachineType\CigaretteMachine;

class MachineFactory
{
    public static function createMachine($machineName)
    {
        switch ($machineName) {
            case 'cigarette':
                return new CigaretteMachine();
                break;
            default:
                return false;
        }
    }

}