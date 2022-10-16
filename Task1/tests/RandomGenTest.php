<?php

namespace App\Tests;

use App\Service\RandomGen;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RandomGenTest extends KernelTestCase
{

    /**
     * we are willing to accept 5% difference
     */
    const MARGING = 0.05;

    /**
     * number iteration for the tests
     */
    const TOTAL = 100000;

    protected function assertRandomValIsAcceptable($val, $pourcent)
    {
        $accurateVal = $val * $pourcent;
        $minVal = $accurateVal - (self::TOTAL * (1 - self::MARGING));
        $maxVal = $accurateVal + (self::TOTAL * (1 + self::MARGING));

        $this->assertTrue($minVal <  $val && $val < $maxVal);
    }

    function testRandomGenFor100000ElemFor2()
    {
        $randomNumbers = ['10', '20'];
        $probabilities = [0.2, 0.8];

        $res = ['10' => 0, '20' => 0];
        $count = 100000;
        while ($count) {
            $key = RandomGen::nextNum($randomNumbers, $probabilities);
            $res[$key] = $res[$key] + 1;
            $count--;
        }


        $this->assertRandomValIsAcceptable($res['10'], 0.2);
        $this->assertRandomValIsAcceptable($res['20'], 0.8);
    }

    function testRandomGenFor100000ElemFor5()
    {
        $randomNumbers = ['10', '20', '30', '40', '50'];
        $probabilities = [0.01 , 0.1, 0.3, 0.5, 0.09];

        $res = ['10'  => 0, '20'  => 0, '30'  => 0, '40'  => 0, '50'  => 0];
        $count = 100000;
        while ($count) {
            $key = RandomGen::nextNum($randomNumbers, $probabilities);
            $res[$key] = $res[$key] + 1;
            $count--;
        }

        foreach ($randomNumbers as $index =>  $number){
            $this->assertRandomValIsAcceptable($res[$number], $probabilities[$index]);
        }
    }

    function testCheckProbaAlwaysHaveHundredPourcent()
    {
        $randomNumbers = ['3', '5'];

        $probabilities = [0.35, 0.8];
        $this->assertFalse(RandomGen::isValid($randomNumbers, $probabilities));

        $probabilities = [0.15, 1.85];
        $this->assertFalse(RandomGen::isValid($randomNumbers, $probabilities));

        $probabilities = [0.15, 0.85];
        $this->assertTrue(RandomGen::isValid($randomNumbers, $probabilities));
    }

    function testCheckAlwaysOneNumberMin()
    {
        $randomNumbers = [];
        $probabilities = [];

        $this->assertFalse(RandomGen::isValid($randomNumbers, $probabilities));

        $randomNumbers = ['100'];
        $probabilities = [1];
        $this->assertTrue(RandomGen::isValid($randomNumbers, $probabilities));
    }
}