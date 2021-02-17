<?php

namespace App;

use Args;

class Console
{

    static function write(string $input, bool $verboseOlny = false)
    {
        if($verboseOlny){
            if(Args::get('verbose')){
                echo $input;
            }
        }
        else{
            echo $input;
        }
    }
    static function writeLine(string $input = null, bool $verboseOnly = false)
    {
            Console::write(($input??"")."\n", $verboseOnly);
    }

    static function warn(string $input = null)
    {
        if (!is_null($input)) {
            Console::write("WARNING: ".$input, false);
        }
        echo "\n";
    }

}
