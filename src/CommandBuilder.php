<?php

namespace MilesChou\Commander;

class CommandBuilder
{
    /**
     * @var string
     */
    private $entry;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @param string $entry
     */
    public function __construct(string $entry)
    {
        $this->entry = $entry;
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
                return $c . ' -' . implode(' ', $v);
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
     * @param string|null $value
     * @return CommandBuilder
     */
    public function option(string $option, string $value = null): CommandBuilder
    {
        if (null === $value) {
            $this->options[] = [$option];
        } else {
            $this->options[] = [$option, $value];
        }

        return $this;
    }
}
