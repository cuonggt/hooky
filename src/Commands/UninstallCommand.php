<?php

namespace Cuonggt\Hooky\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class UninstallCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('uninstall');
    }

    /**
     * Executes the current command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Process::fromShellCommandline('git config --unset core.hooksPath')->run();

        return 0;
    }
}
