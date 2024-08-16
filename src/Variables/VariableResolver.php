<?php

namespace MreeP\QuickTemplate\Variables;

/**
 * Interface VariableResolver
 *
 * Interface for variable resolvers.
 */
interface VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Resolve the variable.
     *
     * @param  ParsedVariableArguments $arguments
     * @param  array                   $data
     * @param  array                   $file
     * @return string
     */
    public function resolve(ParsedVariableArguments $arguments, array $data, array $file = []): string;
}