<?php

namespace Cuonggt\Hooky\Commands;

use Cuonggt\Hooky\Hooky;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('set')
            ->addArgument('file', InputArgument::REQUIRED)
            ->addArgument('cmd', InputArgument::REQUIRED);
    }

    /**
     * Executes the current command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Hooky::set($file = $input->getArgument('file'), $input->getArgument('cmd'));

        $output->writeln("created {$file}");

        return 0;
    }
}
