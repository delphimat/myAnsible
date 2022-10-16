<?php

namespace App\Service;

use Spatie\Ssh\Ssh;
use Symfony\Component\Process\Process;

/**
 * Class use to manage the tasks
 */
class TaskManager
{
    /**
     * this method will run an ssh command to the host
     * @param TargetServerManager $targetServer
     * @param string $cmd
     * @param LoggerManager|null $loggerManager
     * @return void
     */
    public function runBash(TargetServerManager $targetServer, string $cmd, ?LoggerManager $loggerManager = null): void
    {
        $ips = $targetServer->getIps();

        if (0 == count($ips)) {
            $loggerManager->addFailedTask($targetServer, $cmd, sprintf("Didnt find the host's IP: %s", $targetServer->getHosts()));
            return ;
        }

        foreach ($targetServer->getIps() as $ip) {
            $process = Ssh::create($targetServer->getUser(), $ip)->configureProcess(fn (Process $process) => $process->setTimeout(30))->execute($cmd);
            if (!$process->isSuccessful()) {
                $loggerManager->addFailedTask($targetServer, $cmd, 'ProcessFailedException');
            } else {
                $loggerManager->addSuccessTask($targetServer, $cmd, $process->getOutput());
            }
        }
    }
}