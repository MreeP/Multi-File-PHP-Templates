<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\CamelCaseFormatter;
use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class CamelCaseFormatterTest
 *
 * Test formatting content as camel case.
 */
final class CamelCaseFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new CamelCaseFormatter();
        parent::setUp();
    }

    /**
     * Test if camel case formatter returns the same content for empty content.
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
     * Test if camel case formatter formats the content as camel case.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_camel_case(): void
    {
        $content = 'Example_content';
        $this->assertEquals('exampleContent', $this->formatter->format($content));
    }

    /**
     * Test if camel case formatter removes spaces from the content.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_camel_case_and_removes_spaces(): void
    {
        $content = '  Example_content  ';
        $this->assertEquals('exampleContent', $this->formatter->format($content));
    }

    /**
     * Test if camel case formatter removes hyphens and underscores from the content.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_camel_case_and_removes_hyphens_and_underscores(): void
    {
        $content = '  Example_con-tent  ';
        $this->assertEquals('exampleConTent', $this->formatter->format($content));
    }
}