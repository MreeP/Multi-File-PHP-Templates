<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Formatters\TrimFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class TrimmedFormatterTest
 *
 * Test formatting content as trimmed version.
 */
final class TrimFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new TrimFormatter();
        parent::setUp();
    }

    /**
     * Test if trim formatter returns the same content for empty content.
     *
     * @return void
     */
    #[Test]
    public function it_returns_the_same_content_for_empty_input(): void
    {
        $content = '';
        $this->assertEquals($content, $this->formatter->format($content));
    }

    /**
     * Test if trim formatter trims spaces from the content.
     *
     * @return void
     */
    #[Test]
    public function it_trims_spaces_from_the_content(): void
    {
        $content = '  content123  ';
        $this->assertEquals('content123', $this->formatter->format($content));
    }

    /**
     * Test if trim formatter trims spaces from the content.
     *
     * @return void
     */
    #[Test]
    public function it_trims_other_defined_characters(): void
    {
        $formatter = new TrimFormatter(' 123');
        $content = '  321content123  ';
        $this->assertEquals('content', $formatter->format($content));
    }
}