<?php

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\AssertionFailedError;


class CustomTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    // ANSI color codes
    private $green = "\033[32m";
    private $yellow = "\033[33m";
    private $reset = "\033[0m";

    public function endTest(Test $test, float $time): void
    {
        // echo $this->green . "Test '" . get_class($test) . "' ended." . $this->reset . PHP_EOL;
        // Additional green colored output
    }

    public function endTestSuite(TestSuite $suite): void
    {
        // echo $this->yellow . "Test suite '" . $suite->getName() . "' ended." . $this->reset . PHP_EOL;
        // Additional yellow colored output
    }
}
