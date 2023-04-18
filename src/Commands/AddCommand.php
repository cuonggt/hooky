<?php

namespace Cuonggt\Hooky\Commands;

use Cuonggt\Hooky\Hooky;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('add')
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
        $file = $input->getArgument('file');

        Hooky::add($file, $input->getArgument('cmd'));

        $output->writeln("updated {$file}");

        return 0;
    }
}
