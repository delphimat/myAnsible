<?php

namespace App\Tests;

use App\Service\HostManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HostManagerTest extends KernelTestCase
{
    public function testHostFile()
    {
        $hostManager = new HostManager(HostManager::DEV_HOSTS_PATH);

        $ips = $hostManager->getIps('all');
        $this->assertTrue(count($ips) == 3);
        $ips = $hostManager->getIps('dbservers');
        $this->assertTrue(count($ips) == 1);
        $ips = $hostManager->getIps('webservers');
        $this->assertTrue(count($ips) == 2);
    }
}