<?php

namespace MreeP\QuickTemplate\Tests\Stubs;

use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class DummyContext
 *
 * Dummy context for testing purposes.
 */
class DummyContext implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'dummy';
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
        if (count($arguments)) {
            return array_values($arguments->all())[0];
        } else {
            return $this->getName();
        }
    }
}