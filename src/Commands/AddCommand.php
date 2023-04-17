<?php

namespace Cuonggt\Hooky\Commands;

use RuntimeException;
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
        $dir = dirname($file = $input->getArgument('file'));

        if (! is_dir($dir)) {
            throw new RuntimeException("can't create hook, {$dir} directory doesn't exist (try running hooky install)");
        }

        $fp = fopen($file, 'w');
        fwrite($fp, "#!/usr/bin/env sh\n");
        fwrite($fp, ". \"$(dirname -- \"$0\")/_/hooky.sh\"\n");
        fwrite($fp, "{$input->getArgument('cmd')}\n");
        fclose($fp);
        chmod($file, 0755);

        $output->writeln("created {$file}");

        return 0;
    }
}
