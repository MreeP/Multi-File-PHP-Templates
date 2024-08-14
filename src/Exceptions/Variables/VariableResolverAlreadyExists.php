<?php

namespace MreeP\QuickTemplate\Exceptions\Variables;

/**
 * class VariableResolverAlreadyExists
 *
 * Exception for when a variable resolver already exists.
 */
class VariableResolverAlreadyExists extends VariableException
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $message
     */
    public function __construct(string $message = 'The variable resolver already exists.')
    {
        parent::__construct($message);
    }
}