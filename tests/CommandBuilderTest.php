<?php

namespace Tests;

use MilesChou\Commander\CommandBuilder;
use PHPUnit\Framework\TestCase;

class CommandBuilderTest extends TestCase
{
    public function examples()
    {
        return [
            [
                'ls -a',
                (new CommandBuilder('ls'))->option('a')
            ],
            [
                'php -S 0.0.0.0:8080 .',
                (new CommandBuilder('php'))->option('S', '0.0.0.0:8080')->arg('.')
            ],
        ];
    }

    /**
     * @dataProvider examples
     * @test
     */
    public function shouldBeOkayForBuilderExamples($excepted, CommandBuilder $target)
    {
        $this->assertEquals($excepted, $target->build());
    }
}
