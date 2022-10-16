<?php

namespace App\Tests;

use App\Service\PlaybookManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlaybookManagerTest extends KernelTestCase
{
    const PATH_PLAY_BOOK = 'data/playbook-proton.yml';

    function testRun()
    {
        $playbookManager = new PlaybookManager();
        $playbookManager->run(self::PATH_PLAY_BOOK);
    }
}