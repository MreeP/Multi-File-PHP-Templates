<?php

namespace MreeP\QuickTemplate\Exceptions\Variables;

use RuntimeException;

/**
 * class VariableException
 *
 * Exception for variables.
 */
class VariableException extends RuntimeException
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $message
     */
    public function __construct(string $message = 'An error occurred with the variable.')
    {
        parent::__construct($message);
    }
}