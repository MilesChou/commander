<?php

namespace MilesChou\Commander;

use BadMethodCallException;

class CommandBuilder
{
    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var GeneralCommand|null
     */
    private $command;

    /**
     * @var string
     */
    private $entry;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @param string $entry
     * @param GeneralCommand|null $command
     */
    public function __construct(string $entry, GeneralCommand $command = null)
    {
        $this->entry = $entry;
        $this->command = $command;
    }

    public function __call($name, $arguments)
    {
        if (null !== $this->command && method_exists($this->command, $name)) {
            return $this->command->{$name}(...$arguments);
        }

        throw new BadMethodCallException("Undefined method '$name'");
    }

    /**
     * @param string $arg
     * @return CommandBuilder
     */
    public function arg(string $arg): CommandBuilder
    {
        $this->arguments[] = $arg;

        return $this;
    }

    /**
     * Build command string
     *
     * @return string
     */
    public function build(): string
    {
        $command = $this->entry;

        if (!empty($this->options)) {
            $options = trim(array_reduce($this->options, function ($c, $v) {
                if (strlen($v[0]) === 1) {
                    return $c . ' -' . implode(' ', $v);
                }

                return $c . ' --' . implode(' ', $v);
            }, ''));

            $command .= ' ' . $options;
        }

        if (!empty($this->arguments)) {
            $arguments = trim(implode(' ', $this->arguments));

            $command .= ' ' . $arguments;
        }

        return $command;
    }

    /**
     * @param string $option
     * @param array|string|null $value
     * @return CommandBuilder
     */
    public function option(string $option, $value = null): CommandBuilder
    {
        if (null === $value) {
            $this->options[] = [$option];
            return $this;
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $v) {
            $this->options[] = [$option, $v];
        }

        return $this;
    }
}
