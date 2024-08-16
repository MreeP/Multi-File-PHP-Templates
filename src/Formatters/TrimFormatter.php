<?php

namespace MreeP\QuickTemplate\Formatters;

/**
 * class AsIsFormatter
 *
 * class for trimming content.
 */
class TrimFormatter implements OutputFormatter
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $characters
     */
    public function __construct(
        protected string $characters = " \n\r\t\v\0",
    ) {}

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'trimmed';
    }

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string
    {
        return trim($content, $this->characters);
    }
}