<?php

namespace App\Socket;

use App\Console;
use App\Dayz\Server;
use Dayz\Dayz;

class TcpListener
{

    public static function startListening($address = null, $port = null)
    {
        $address = $address ?? env('SOCKET_ADDRESS', "172.0.0.1");
        $port = $port ?? env('SOCKET_PORT', 5555);

        $socket = socket_create_listen($port);
        if (!$socket) {
            Console::warn('Failed to create socket!');
            printf($socket);
            die();
        }

        Console::writeLine("Listener Started!");

        while (true) {
            Console::writeLine("Listening...",true);
            Console::writeLine("",true);

            $client = socket_accept($socket);
            if (!$client) {
                Console::warn('Failed to connect to client!');
                break;
            }
            while (true) {
                $msg = @socket_read($client, 1024);

                if ($msg != false) {
                    $input = trim($msg);
                    Console::writeLine("Received: ".$input,true);
                    $output = var_export(TcpListener::interpret($input),true);
                    Console::writeLine("Response: ".$output,true);
                    socket_write($client, $output);
                } else {
                    break;
                }
            }
            socket_close($client);
            Console::writeLine("End of transaction.",true);

            Console::writeLine("",true);
            Console::writeLine("",true);
        }
        socket_close($socket);
    }


    static function interpret($message)
    {
        $parameters = explode(' ', str_replace("\r\n", "", $message));
        $command = $parameters[0];
        unset($parameters[0]);

        switch (strtolower($command)) {
            case 'echo':
                return implode(' ', $parameters);
            case 'start':
                return Server::Start($parameters);
            case 'restart':
                return Server::Restart($parameters);
            case 'isrunning':
                return Server::isRunning();
            case 'kill':
                return Server::Kill();
            default:
                return "Command \"" . $command . "\" not found\r\n";
        }
    }
}
