<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * class SnakeCaseFormatter
 *
 * Use this class to format a string to snake case.
 */
class SnakeCaseFormatter implements OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'snake';
    }

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string
    {
        $content = preg_replace('/\s+/u', '', ucwords($content));

        return mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $this->getDelimiter(), $content));
    }

    /**
     * Get the delimiter.
     *
     * @return string
     */
    protected function getDelimiter(): string
    {
        return '_';
    }
}