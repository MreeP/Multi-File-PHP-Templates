<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Formatters\SnakeCaseFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class SnakeCaseFormatterTest
 *
 * Test formatting content as snake case version.
 */
final class SnakeCaseFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new SnakeCaseFormatter();
        parent::setUp();
    }

    /**
     * Test if snake formatter returns the same content for empty content.
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
     * Test if snake formatter formats the content as snake case.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_snake_case(): void
    {
        $content = 'mulTi word123 content';
        $this->assertEquals('mul_ti_word123_content', $this->formatter->format($content));
    }
}