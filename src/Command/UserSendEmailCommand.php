<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserSendEmailCommand extends Command
{
    protected static $defaultName = 'user:send:email';
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * UserSendEmailCommand constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct(null);
        $this->userRepository = $userRepository;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Adds user to email queue')
            ->addArgument('email', InputArgument::REQUIRED, 'User\'s email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $userEmail = $input->getArgument('email');

        if ($userEmail) {
            $io->note(sprintf('You passed an user\'s email: %s', $userEmail));
        }
    
        $user = $this->userRepository->findOneBy([
            'email' => $userEmail,
        ]);
    
        if (!isset($user)) {
            $io->error('User with ' . $userEmail . ' not found!');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
