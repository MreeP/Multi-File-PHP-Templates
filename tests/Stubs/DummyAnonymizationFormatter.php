<?php

namespace MreeP\QuickTemplate\Tests\Stubs;

use MreeP\QuickTemplate\Formatters\OutputFormatter;

/**
 * class DummyContext
 *
 * Dummy output formatter for testing purposes.
 */
class DummyAnonymizationFormatter implements OutputFormatter
{

    /**
     * Get the name of the formatter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'dummy';
    }

    /**
     * Format the given content.
     *
     * @param  string $content
     * @return string
     */
    public function format(string $content): string
    {
        return strlen($content) > 0
            ? str_repeat('*', strlen($content))
            : $this->name();
    }
}