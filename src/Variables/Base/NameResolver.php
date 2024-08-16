<?php

namespace MreeP\QuickTemplate\Variables\Base;

use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class NameResolver
 *
 * Resolver for the name variable.
 */
class NameResolver implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return mixed
     */
    public function getName(): string
    {
        return 'name';
    }

    /**
     * Resolve the variable.
     *
     * @param  ParsedVariableArguments $arguments
     * @param  array                   $data
     * @param  array                   $file
     * @return mixed
     */
    public function resolve(ParsedVariableArguments $arguments, array $data, array $file = []): string
    {
        $result = strstr($file['template_file_path'], '.', true);

        return $result === false
            ? ''
            : mb_convert_case($result, MB_CASE_TITLE, 'UTF-8');
    }
}