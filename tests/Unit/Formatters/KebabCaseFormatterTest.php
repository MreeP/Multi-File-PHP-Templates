<?php

namespace MreeP\QuickTemplate\Tests\Unit\Formatters;

use MreeP\QuickTemplate\Formatters\KebabCaseFormatter;
use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * class KebabCaseFormatterTest
 *
 * Test formatting content as kebab case version.
 */
final class KebabCaseFormatterTest extends TestCase
{

    protected OutputFormatter $formatter;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->formatter = new KebabCaseFormatter();
        parent::setUp();
    }

    /**
     * Test if kebab formatter returns the same content for empty content.
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
     * Test if kebab formatter formats the content as kebab case.
     *
     * @return void
     */
    #[Test]
    public function it_formats_content_as_kebab_case(): void
    {
        $content = 'mulTi word123 content';
        $this->assertEquals('mul-ti-word123-content', $this->formatter->format($content));
    }
}