<?php

namespace Cuonggt\Hooky;

use Exception;
use Symfony\Component\Process\Process;

class Hooky
{
    /**
     * @param  $dir  string
     * @return void
     */
    public static function install(string $dir = '.hooky')
    {
        if (! is_dir($dir.'/_')) {
            mkdir($dir.'/_', 0755, true);
        }

        $fp = fopen($dir.'/_/.gitignore', 'w');
        fwrite($fp, '*');
        fclose($fp);

        copy(__DIR__.'/../../hooky.sh', $dir.'/_/hooky.sh');

        Process::fromShellCommandline('git config core.hooksPath .hooky')->run();
    }

    /**
     * @param  $file  string
     * @param  $cmd  string
     * @return void
     */
    public static function set(string $file, string $cmd)
    {
        if (! is_dir($dir = dirname($file))) {
            throw new Exception("can't create hook, {$dir} directory doesn't exist (try running hooky install)");
        }

        $fp = fopen($file, 'w');
        fwrite($fp, "#!/usr/bin/env sh\n");
        fwrite($fp, ". \"$(dirname -- \"$0\")/_/hooky.sh\"\n\n");
        fwrite($fp, "{$cmd}\n");
        fclose($fp);
        chmod($file, 0755);
    }

    /**
     * @param  $file  string
     * @param  $cmd  string
     * @return void
     */
    public static function add(string $file, string $cmd)
    {
        if (file_exists($file)) {
            $fp = fopen($file, 'a');
            fwrite($fp, "{$cmd}\n");
            fclose($fp);
        } else {
            static::set($file, $cmd);
        }
    }
}
