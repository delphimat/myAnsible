<?php

namespace App\Service;

class RandomGen
{
    /**
     * Use this method if you want to valid the parametersx
     * @param array $randomNumbers
     * @param array $probabilities
     * @return bool
     */
    static public function isValid(array $randomNumbers, array $probabilities): bool
    {
        if (0 == count($randomNumbers) || 0 == count($probabilities)) {
            return false;
        }

        if (round(1, 2) != round(array_sum($probabilities), 2)) {
            return false;
        }

        return count($randomNumbers) == count($probabilities);
    }

    /**
     * this method will generate the next random num
     * @param array $randomNumbers
     * @param array $probabilities
     * @return string
     */
    static public function nextNum(array $randomNumbers, array $probabilities): string
    {
        $rand = mt_rand(1, intval(array_sum($probabilities) * 100));

        foreach ($probabilities as $index => $probability) {
            $rand -= $probability * 100;
            if ($rand <= 0) {
                return $randomNumbers[$index];
            }
        }
    }
}