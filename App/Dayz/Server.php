<?php

namespace App\Dayz;

use App\Console;

/**
 * Dayz Server Class. For now does simple stuff like starting and killing it.
 */
class Server
{

    /**
     * Starts the Dayz Server with the given parameters
     *
     * @param array $parameters Parameters used along with the server exe
     * @return mixed Returns true if server started. Returns an string if it didn't
     */
    public static function Start(array $parameters)
    {
        $executable = env('DAYZ_EXECUTABLE','..\DayZServer_x64.exe');
        $root = env('DAYZ_ROOT','C:\Program Files (x86)\Steam\steamapps\common\DayZServer\\');
        $fullpath = $root.$executable;
        $parametersString = implode(' ', $parameters);
        $startString = $fullpath.' '.$parametersString;
        popen("start " . $startString,'r');
        return Server::isRunning();
    }

    /**
     * Indicates if the server is running
     *
     * @return boolean Well, what do you expect?
     */
    public static function isRunning()
    {
        $nope = 'INFO: No tasks are running which match the specified criteria.';
        $executable = env('DAYZ_EXECUTABLE','DayZServer_x64.exe');
        $result = shell_exec('tasklist /FI "IMAGENAME eq '.$executable.'"');
        return str_starts_with(trim($result),$nope) ? false : true;
    }

    /**
     * Kills the DayZ Server
     *
     * @return void
     */
    public static function Kill(){
        $executable = env('DAYZ_EXECUTABLE','..\DayZServer_x64.exe');
        return shell_exec('taskkill /FI "IMAGENAME eq '.$executable.'" /F');
    }

    /**
     * Restarts the Dayz Server with the given parameters
     *
     * @param array $parameters Parameters used along with the server exe
     * @return mixed Returns true if server started. Returns an string if it didn't
     */
    public static function Restart(array $parameters){
        Server::Kill();
        Server::Start($parameters);
    }
}
