<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\AsIsFormatter;
use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class AsIsFormatterTest
 *
 * Test formatting content as is.
 */
final class AsIsFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new AsIsFormatter();
        parent::setUp();
    }

    /**
     * Test if as-is formatter returns the same content.
     *
     * @return void
     */
    #[Test]
    public function it_returns_the_same_content(): void
    {
        $content = 'some content';
        $this->assertEquals($content, $this->formatter->format($content));
    }

    /**
     * Test if as-is formatter returns the same content for numeric input.
     *
     * @return void
     */
    #[Test]
    public function it_returns_the_same_numeric_content(): void
    {
        $content = '0123456789';
        $this->assertEquals($content, $this->formatter->format($content));
    }

    /**
     * Test if as-is formatter returns the same content for special characters input.
     *
     * @return void
     */
    #[Test]
    public function it_returns_the_same_special_content(): void
    {
        $content = "'~!@#$%^&*()_+`-={}|[]\\;':\",./<>?\t\n'";
        $this->assertEquals($content, $this->formatter->format($content));
    }
}