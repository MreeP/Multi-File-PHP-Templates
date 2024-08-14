<?php

namespace MreeP\QuickTemplate\Variables\Base;

use MreeP\QuickTemplate\Exceptions\Template\TemplateDataKeyDoesNotExist;
use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class DataResolver
 *
 * Resolver for the data variable.
 */
class DataResolver implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return mixed
     */
    public function getName(): string
    {
        return 'data';
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
        if ($arguments->getFlag('required') && !array_key_exists($key = $arguments->getValue('key'), $data)) {
            throw new TemplateDataKeyDoesNotExist("Template required data key \"$key\" does not exist.");
        }

        return $data[$arguments->getValue('key')];
    }
}