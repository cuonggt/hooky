<?php

namespace Cuonggt\Hooky\Commands;

use Exception;
use RuntimeException;
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
        $process = new Process(['git', 'rev-parse']);

        $process->run();

        if ($process->getExitCode() !== 0) {
            $output->writeln('git command not found, skipping install');
            return Command::FAILURE;
        }

        if (! is_dir('.git')) {
            throw new RuntimeException(".git can't be found!");
        }

        if (! is_dir('.hooky/_')) {
            mkdir('.hooky/_', 0755, true);
        }

        try {
            $fp = fopen('.hooky/_/.gitignore', 'w');
            fwrite($fp, '*');
            fclose($fp);

            copy(__DIR__.'/../../hooky.sh', '.hooky/_/hooky.sh');

            Process::fromShellCommandline('git config core.hooksPath .hooky')->run();
        } catch (Exception $e) {
            $output->writeln('Git hooks failed to install');
            throw $e;
        }

        $output->writeln('Git hooks installed');

        return 0;
    }
}
