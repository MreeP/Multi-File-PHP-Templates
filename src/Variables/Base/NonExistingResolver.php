<?php

namespace MreeP\QuickTemplate\Variables\Base;

use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class NonExisting
 */
class NonExistingResolver implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'non-existing';
    }

    /**
     * Resolve the variable.
     *
     * @param  ParsedVariableArguments $arguments
     * @param  array                   $data
     * @param  array                   $file
     * @return string
     */
    public function resolve(ParsedVariableArguments $arguments, array $data, array $file = []): string
    {
        return '';
    }
}