<?php

namespace MilesChou\Commander;

use LogicException;
use MongoDB\Driver\Command;

class GeneralCommand
{
    /**
     * @var string
     */
    private $entry;

    /**
     * @var CommandBuilder[]
     */
    private $subCommand = [];

    /**
     * @param string $entry
     */
    public function __construct(string $entry)
    {
        $this->entry = $entry;
    }

    public function __get($name)
    {
        $builder = new CommandBuilder($name, $this);

        $this->subCommand[] = $builder;

        return $builder;
    }

    public function __set($name, $value)
    {
        throw new LogicException('Cannot set property');
    }

    public function __isset($name)
    {
        throw new LogicException('Cannot check property');
    }

    /**
     * Build command string
     *
     * @return string
     */
    public function toString(): string
    {
        $command = $this->entry;

        foreach ($this->subCommand as $sub) {
            $command .= ' ' . $sub->build();
        }

        return $command;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
