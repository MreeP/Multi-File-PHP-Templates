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
     * @return mixed
     */
    public function getName(): string;

    /**
     * Resolve the variable.
     *
     * @param  ParsedVariableArguments $arguments
     * @param  array                   $data
     * @param  array                   $file
     * @return mixed
     */
    public function resolve(ParsedVariableArguments $arguments, array $data, array $file = []): string;
}