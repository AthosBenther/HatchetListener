<?php
require "vendor/autoload.php";

use App\Boot;
use App\Console;


Console::writeLine();
Console::writeLine("Starting Hatchet Listener");
Console::writeLine();
Boot::boot($argv);
Console::writeLine("",true);
Console::writeLine("Listener booted sucessfully");