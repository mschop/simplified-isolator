<?php

namespace SimplifiedIsolator;

use PHPUnit\Framework\TestCase;

class IsolatorTest extends TestCase
{
    function test()
    {
        $testText = 'Hello World';
        $file = __FILE__;

        $isolator = new Isolator([
            'file_get_contents' => fn() => $testText,
        ]);

        $this->assertEquals($testText, $isolator->file_get_contents($file));
        $this->assertEquals(file_get_contents($file), (new Isolator)->file_get_contents($file));
    }
}