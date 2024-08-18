<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * class KebabCaseFormatter
 *
 * Use this class to format a string as kebab case.
 */
class KebabCaseFormatter extends SnakeCaseFormatter implements OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'kebab';
    }

    /**
     * Get the delimiter.
     *
     * @return string
     */
    protected function getDelimiter(): string
    {
        return '-';
    }
}