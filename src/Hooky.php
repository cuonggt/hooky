<?php

namespace Cuonggt\Hooky;

use Exception;

class Hooky
{
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
        fwrite($fp, ". \"$(dirname -- \"$0\")/_/hooky.sh\"\n");
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
        if (! file_exists($file)) {
            return static::set($file, $cmd);
        }

        $fp = fopen($file, 'a');
        fwrite($fp, "{$cmd}\n");
        fclose($fp);
    }
}
