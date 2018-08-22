<?php

namespace Balticode\Billink\Helper;

/**
 * Class Number
 * @package Balticode\Billink\Helper
 */
class Number
{
    /**
     * @param float $number1
     * @param float $number2
     * @return bool
     */
    public function floatsAreEqual($number1, $number2)
    {
        if ($number2 == 0.00) {
            return false;
        }

        return (abs(($number1 - $number2) / $number2) < 0.00001);
    }
}