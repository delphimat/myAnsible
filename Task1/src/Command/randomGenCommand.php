<?php

namespace App\Command;

use App\Service\RandomGen;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class randomGenCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultDescription = 'Run the method nextNum() with the params';
    /**
     * @var string
     */
    protected static $defaultName = 'random:gen';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('randoms', InputArgument::REQUIRED, 'Random Numbers')
            ->addArgument('probs', InputArgument::REQUIRED, 'Probabilities')
            ->addArgument('count', InputArgument::OPTIONAL, 'how many time this should be run')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $randomsInput = $input->getArgument('randoms');
        $probsInput = $input->getArgument('probs');
        $countInput = $input->getArgument('count') ?? 1;

        $output->writeln([
            'Random Gen',
            '============',
            sprintf("randoms: %s", $randomsInput),
            sprintf("probs: %s", $probsInput),
            sprintf("count: %s", $countInput),
            '============',
            '',
        ]);

        $randoms = json_decode($randomsInput);
        $probs = json_decode($probsInput);
        $count = intval($countInput);

        if (empty($randoms) || empty($probs)) {
            $output->writeln("arguments not valid, please have a look in the readme.md");
            return Command::INVALID;
        }

        if (!RandomGen::isValid($randoms, $probs) || 0 == $count) {
            $output->writeln("arguments not valid");
            return Command::INVALID;
        }

        $output->writeln("we can run the script");
        $result = [];

        while (0 < $count) {
            $num = RandomGen::nextNum($randoms, $probs);
            if (!isset($result[$num])) {
                $result[$num] = 0;
            } else {
                $result[$num] =  $result[$num] + 1;
            }
            $count--;
        }

        $output->writeln([
            'final result ',
            '============',
            '',
        ]);

        foreach ($randoms as $random) {
            $output->writeln(sprintf("%s: %d times", $random, $result[$random] ?? 0));
        }

        return Command::SUCCESS;
    }
}