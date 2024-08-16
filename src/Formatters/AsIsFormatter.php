<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * class AsIsFormatter
 *
 * class for formatting content as is.
 */
class AsIsFormatter implements OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'as-is';
    }

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string
    {
        return $content;
    }
}