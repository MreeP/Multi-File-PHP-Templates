<?php

namespace MreeP\QuickTemplate\Tests\Unit\Replacement;

use Exception;
use MreeP\QuickTemplate\Context\Context;
use MreeP\QuickTemplate\Replacement\VariablesReplacer;
use MreeP\QuickTemplate\Tests\Stubs\DummyContext;
use MreeP\QuickTemplate\Tests\TestCase;
use MreeP\QuickTemplate\Variables\VariableDetector;
use PHPUnit\Framework\Attributes\Test;

/**
 * class VariableDetectionTest
 *
 * Test variable matching pattern
 */
final class TextVariableReplacementTest extends TestCase
{

    protected VariablesReplacer $replacer;

    /**
     * Setup the test environment.
     *
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->replacer = new VariablesReplacer(
            Context::default([new DummyContext()]),
            new VariableDetector(),
        );

        parent::setUp();
    }

    /**
     * Test if the class can detect and replace variables in a given text.
     *
     * @return void
     */
    #[Test]
    public function it_replaces_variables_in_text()
    {
        $this->assertEquals(
            'Hello dummy how is your day',
            $this->replacer->handleReplacement('Hello [[ dummy ]] how is your [[ dummy value="day" ]]'),
        );
    }

    /**
     * Test if the class can detect and replace variables in
     * a given text and remove it if variable does not exist.
     *
     * @return void
     */
    #[Test]
    public function it_replaces_variables_in_text_and_removes_invalid_ones()
    {
        $this->assertEquals(
            'Hello dummy how is your ',
            $this->replacer->handleReplacement('Hello [[ dummy ]] how is your [[ invalid-dummy value="day" ]]'),
        );
    }
}