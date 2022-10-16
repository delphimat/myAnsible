<?php

namespace App\Tests;

use App\Service\LoggerManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoggerManagerTest extends KernelTestCase
{
    protected LoggerManager $loggerManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->loggerManager = new LoggerManager();
    }

    public function testAddPlaybookPath()
    {
        $this->loggerManager->addPlayBookPath("path/");
        $this->assertTrue(2 === count($this->loggerManager->getLogs()));
    }

    public function testAddTask()
    {
        $this->loggerManager->addTask("path/");
        $this->assertTrue(2 === count($this->loggerManager->getLogs()));
    }

    public function testAddFailedTask()
    {
        $this->loggerManager->addFailedTask("name", "error msg");
        $this->assertTrue(1 === count($this->loggerManager->getLogs()));
    }

    public function testAddSuccessTask()
    {
        $this->loggerManager->addSuccessTask("name", "task", "[test]");
        $this->assertTrue(1 === count($this->loggerManager->getLogs()));
    }
}