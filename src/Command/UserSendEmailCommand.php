<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserSendEmailCommand extends Command
{
    protected static $defaultName = 'user:send:email';

    protected function configure()
    {
        $this
            ->setDescription('Adds user to email queue')
            ->addArgument('user', InputArgument::REQUIRED, 'User which receive an email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $userArg = $input->getArgument('user');

        if ($userArg) {
            $io->note(sprintf('You passed an user: %s', $userArg));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
