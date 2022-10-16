<?php

namespace App\Service;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Main class to load the playbook
 */
class PlaybookManager
{
    const TASK_BASH = 'bash';
    const TASK_NAME = 'name';

    protected LoggerManager $loggerManager;
    protected TaskManager $taskManager;

    public function __construct()
    {
        $this->loggerManager = new LoggerManager();
        $this->taskManager = new TaskManager();
    }

    /**
     * @param string $playBookPath
     * @return bool
     */
    protected function isPlayBookValid(string $playBookPath): bool
    {
        if (!file_exists($playBookPath)) {
            return false;
        }

        try {
            Yaml::parseFile($playBookPath);
        } catch (ParseException $exception) {
            // log error
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Main method to run the playbook
     * @param string $playBookPath
     * @return void
     */
    public function run(string $playBookPath): void
    {
        if (!$this->isPlayBookValid($playBookPath)) {
            throw new \RuntimeException("Play book path is not valid");
        }

        $playBookParsed = Yaml::parseFile($playBookPath);
        $this->loggerManager->addPlayBookPath($playBookPath);

        foreach ($playBookParsed as  $param) {

            $hosts = $param['hosts'] ?? null;
            $tasks = $param['tasks'] ?? [];
            $name  = $param['name'] ?? null;
            $remoteUser = $param['remote_user'] ?? null;

            $targetServ = new TargetServerManager($name, $hosts, $remoteUser);
            $this->loggerManager->addPlay($targetServ);

            if (count($tasks)) {
                foreach ($tasks as $task) {
                    $taskName = $task[self::TASK_NAME] ?? null;

                    if (null === $taskName) {
                        $this->loggerManager->addFailedTask('', 'name missing in the configuration');
                        continue;
                    }

                    $this->loggerManager->addTask($taskName);
                    try {
                        $this->taskManager->runBash($targetServ, $task[self::TASK_BASH], $this->loggerManager);
                    } catch(ProcessFailedException $error) {
                        $this->loggerManager->addFailedTask($taskName, $error->getMessage());
                    }
                }
            }
        }

    }

    /**
     * return the log to output it to the consol
     * @return array
     */
    public function logs(): array
    {
        return $this->loggerManager->getLogs();
    }
}