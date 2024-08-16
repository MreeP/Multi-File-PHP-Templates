<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * interface OutputFormatter
 *
 * Interface for output formatters.
 */
interface OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string;
}