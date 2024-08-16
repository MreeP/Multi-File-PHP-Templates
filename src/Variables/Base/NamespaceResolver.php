<?php

namespace MreeP\QuickTemplate\Variables\Base;

use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class NamespaceResolver
 *
 * Resolver for the namespace variable.
 */
class NamespaceResolver implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'namespace';
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
        $pathSegments = explode(DIRECTORY_SEPARATOR, $file['output_file_path']);
        $directory = array_slice($pathSegments, 0, -1);

        return trim(
            implode('\\', $directory),
            '\\',
        );
    }
}