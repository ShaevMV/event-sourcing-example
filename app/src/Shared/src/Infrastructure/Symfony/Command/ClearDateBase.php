<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:drop-test-database')]
class ClearDateBase extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // delete database if exists, then create
        passthru('php bin/console doctrine:database:drop --force --if-exists');
        passthru('php bin/console doctrine:database:create');

        // run migrations
        passthru('php bin/console doctrine:migrations:migrate -n');

        return Command::SUCCESS;
    }
}
