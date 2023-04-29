<?php

namespace Cuonggt\Hooky\Commands;

use Cuonggt\Hooky\Hooky;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('install');
    }

    /**
     * Executes the current command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (getenv('HOOKY') === '0') {
            $output->writeln('HOOKY env variable is set to 0, skipping install');
            return Command::FAILURE;
        }

        $process = new Process(['git', 'rev-parse']);

        $process->run();

        if ($process->getExitCode() !== 0) {
            $output->writeln('git command not found, skipping install');
            return Command::FAILURE;
        }

        if (! is_dir('.git')) {
            throw new Exception(".git can't be found!");
        }

        try {
            Hooky::install();
        } catch (Exception $e) {
            $output->writeln('Git hooks failed to install');
            throw $e;
        }

        $output->writeln('Git hooks installed');

        return 0;
    }
}
