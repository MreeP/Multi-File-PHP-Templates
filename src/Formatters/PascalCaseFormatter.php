<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * class CamelCaseFormatter
 *
 * class for formatting content as pascal case.
 */
class PascalCaseFormatter implements OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'camel-case';
    }

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string
    {
        return ucfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $content))));
    }
}