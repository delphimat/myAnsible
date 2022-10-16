<?php

namespace App\Command;

use App\Service\PlaybookManager;
use App\Service\RandomGen;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class AnsiblePlaybookCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultDescription = 'Simple version of Ansible, specifically the ansible-playbook program.';
    /**
     * @var string
     */
    protected static $defaultName = 'ansible:playbook';
    private PlaybookManager $playbookManager;



    public function __construct(PlaybookManager $playbookManager)
    {
        parent::__construct();
        $this->playbookManager = $playbookManager;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('playbook', InputArgument::REQUIRED, 'playbook.yml');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $playbook = $input->getArgument('playbook');

        $this->playbookManager->run($playbook);

        $output->writeln($this->playbookManager->logs());

        return Command::SUCCESS;
    }
}