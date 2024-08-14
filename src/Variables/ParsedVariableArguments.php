<?php

namespace MreeP\QuickTemplate\Variables;

use Countable;

/**
 * class ParsedVariableArguments
 *
 * class for storing and accessing parsed variable arguments
 */
class ParsedVariableArguments implements Countable
{

    /**
     * Class constructor
     *
     * @param  array $arguments
     */
    public function __construct(
        protected array $arguments,
    ) {}

    /**
     * Method to create a new instance of the class.
     *
     * @param  array $arguments
     * @return ParsedVariableArguments
     */
    public static function of(array $arguments): static
    {
        return new static($arguments);
    }

    /**
     * Method to get all arguments.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->arguments;
    }

    /**
     * Method to check if a specific argument exists.
     *
     * @param  string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->arguments);
    }

    /**
     * Method to get a specific argument.
     *
     * @param  string $flag
     * @return bool
     */
    public function getFlag(string $flag): bool
    {
        return array_key_exists($flag, $this->arguments);
    }

    /**
     * Method to get a specific argument.
     *
     * @param  string     $flag
     * @param  null|mixed $default
     * @return mixed
     */
    public function getValue(string $flag, mixed $default = null): mixed
    {
        return $this->arguments[$flag] ?? $default;
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     * @return int<0,max> The custom count as an integer.
     * <p>
     *     The return value is cast to an integer.
     * </p>
     */
    public function count(): int
    {
        return count($this->arguments);
    }
}