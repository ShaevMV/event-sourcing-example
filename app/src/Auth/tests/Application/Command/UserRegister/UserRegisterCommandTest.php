<?php

namespace Tests\Auth\Application\Command\UserRegister;

use ArrangementFee\Application\Command\OrderCreate\OrderCreateCommandHandler;
use Auth\Application\Command\UserRegister\UserRegisterCommand;
use Auth\Application\Command\UserRegister\UserRegisterCommandHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegisterCommandTest extends KernelTestCase
{
    public function testUserRegisterCommand(): void
    {
        $kernel = self::bootKernel();
        /** @var  UserRegisterCommandHandler $handler */
        $handler = $kernel->getContainer()->get(UserRegisterCommandHandler::class);

        $userId = $handler(new UserRegisterCommand(
            'ssss',
            'ddd@dd.ru',
            'secret'
        ));


    }
}