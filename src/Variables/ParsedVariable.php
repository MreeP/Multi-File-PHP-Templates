<?php

namespace MreeP\QuickTemplate\Variables;

/**
 * class ParsedVariable
 *
 * class for parsed variable
 */
class ParsedVariable
{

    /**
     * Class constructor
     *
     * @param  string $raw
     * @param  string $variable
     * @param  array  $arguments
     */
    public function __construct(
        protected string $raw,
        protected string $variable,
        protected array  $arguments = [],
    ) {}

    /**
     * Method to get Raw
     *
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * Method to set Raw
     *
     * @param  string $raw
     * @return ParsedVariable
     */
    public function setRaw(string $raw): ParsedVariable
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * Method to get Variable
     *
     * @return string
     */
    public function getVariable(): string
    {
        return $this->variable;
    }

    /**
     * Method to set Variable
     *
     * @param  string $variable
     * @return ParsedVariable
     */
    public function setVariable(string $variable): ParsedVariable
    {
        $this->variable = $variable;
        return $this;
    }

    /**
     * Method to get Arguments
     *
     * @return ParsedVariableArguments
     */
    public function getArguments(): ParsedVariableArguments
    {
        return ParsedVariableArguments::of($this->arguments);
    }

    /**
     * Method to set Arguments
     *
     * @param  array $arguments
     * @return ParsedVariable
     */
    public function setArguments(array $arguments): ParsedVariable
    {
        $this->arguments = $arguments;
        return $this;
    }
}