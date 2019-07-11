<?php

namespace Tests;

use MilesChou\Commander\CommandBuilder;
use MilesChou\Commander\GeneralCommand;
use PHPUnit\Framework\TestCase;

class GeneralCommandTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayForExecDocker()
    {
        $target = new GeneralCommand('docker');

        $this->assertEquals('docker', $target->toString());
    }

    /**
     * @test
     */
    public function shouldBeOkayForExecDockerRun()
    {
        $target = new GeneralCommand('docker');

        $this->assertEquals('docker run', $target->run->toString());
    }
}
