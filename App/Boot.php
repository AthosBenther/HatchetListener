<?php

namespace App;

use App\Dayz\Server;
use App\Socket\TcpListener;
use Args;
use Symfony\Component\Dotenv\Dotenv;

class Boot
{

    public static function boot(array $args)
    {
        Args::set($args);

        Console::writeLine('Loading .env...',true);
        $dotenv = new Dotenv();
        $dotenv->load('./.env');
        Console::writeLine('Loaded .env',true);

        Console::writeLine('Starting TCP Listener...',true);
        TcpListener::startListening();
    }
}
