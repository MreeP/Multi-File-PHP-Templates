<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Formatters\PascalCaseFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class PascalCaseFormatterTest
 *
 * Test formatting content as pascal case.
 */
final class PascalCaseFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new PascalCaseFormatter();
        parent::setUp();
    }

    /**
     * Test if pascal case formatter returns the same content for empty content.
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
     * Test if pascal case formatter formats the content as pascal case.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_pascal_case(): void
    {
        $content = 'Exam1ple_content';
        $this->assertEquals('Exam1pleContent', $this->formatter->format($content));
    }

    /**
     * Test if pascal case formatter removes spaces from the content.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_pascal_case_and_removes_spaces(): void
    {
        $content = '  Example_content  ';
        $this->assertEquals('ExampleContent', $this->formatter->format($content));
    }

    /**
     * Test if pascal case formatter removes hyphens and underscores from the content.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_pascal_case_and_removes_hyphens_and_underscores(): void
    {
        $content = '  Example_con-tent  ';
        $this->assertEquals('ExampleConTent', $this->formatter->format($content));
    }
}