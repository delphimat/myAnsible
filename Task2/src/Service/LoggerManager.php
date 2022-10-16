<?php

namespace App\Service;

/**
 * Class use to log what happened
 */
class LoggerManager
{
    /**
     * @var array
     */
    protected $logs = [];

    /**
     * @return void
     */
    protected function addSeparator(): void
    {
        $this->logs[] = '**********************************************************************************************************************************
        ';
    }

    /**
     * @param $path
     * @return void
     */
    public function addPlayBookPath($path): void
    {
        $this->logs[] = sprintf("LOAD playbook '%s'", $path);
        $this->addSeparator();
    }

    /**
     * @param TargetServerManager $targetServer
     * @return void
     */
    public function addPlay(TargetServerManager $targetServer): void
    {
        $this->logs[] = sprintf("PLAY [%s]", $targetServer);
        $this->addSeparator();
    }

    /**
     * @param $name
     * @return void
     */
    public function addTask($name): void
    {
        $this->logs[] = sprintf("TASK [%s]", $name);
        $this->addSeparator();
    }

    /**
     * @param $name
     * @param $errorMessage
     * @return void
     */
    public function addFailedTask($name = "", $errorMessage = ""): void {
        $this->logs[] = sprintf('fail: [%s] => {
                            "msg": "%s"
        }
        ', $name, $errorMessage);
    }

    /**
     * @param $name
     * @param $task
     * @param $output
     * @return void
     */
    public function addSuccessTask($name, $task, $output): void {
        $this->logs[] = sprintf('ok: [%s] => {
                        "%s": "%s"
        }
        ', $name, $task, json_encode($output));
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}