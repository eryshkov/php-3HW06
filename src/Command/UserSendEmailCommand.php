<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;

class UserSendEmailCommand extends Command
{
    protected static $defaultName = 'user:send:email';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var string
     */
    private $appMailServiceURL;
    
    /**
     * UserSendEmailCommand constructor.
     */
    public function __construct(UserRepository $userRepository, string $appMailServiceURL)
    {
        parent::__construct(null);
        $this->userRepository = $userRepository;
        $this->appMailServiceURL = $appMailServiceURL;
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
            $io->error('User with email "' . $userEmail . '" not found!');
            return;
        }
    
        $io->note('Found user with ID: ' . $user->getId());
    
        $sendingData = [
            'user_id' => $user->getId(),
            'template_name' => 'test_template.html.twig',
            'template_params' => [
                'from' => 'admin',
                'message' => 'Hello, ',
            ],
        ];
        
        $data = $this->sendPostRequest($this->appMailServiceURL, json_encode($sendingData));
    
        $io->success('User successfully added to queue! Pass --help to see your options.');
    }
    
    protected function sendPostRequest(string $url, string $rawData): string
    {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt(
            $c,
            CURLOPT_POSTFIELDS,
            $rawData);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    
        $data = curl_exec($c);
        curl_close($c);
    
        return $data;
    }
}
