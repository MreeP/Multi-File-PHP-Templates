<?php

namespace MreeP\QuickTemplate\Tests\Unit\Context;

use Exception;
use MreeP\QuickTemplate\Context\Context;
use MreeP\QuickTemplate\Tests\Stubs\DummyAnonymizationFormatter;
use MreeP\QuickTemplate\Tests\Stubs\DummyContext;
use MreeP\QuickTemplate\Tests\TestCase;
use MreeP\QuickTemplate\Variables\ParsedVariable;
use PHPUnit\Framework\Attributes\Test;

/**
 * class OutputFormatOfResolvedVariablesTest
 *
 * Test the output format of resolved variables
 */
final class OutputFormatOfResolvedVariablesTest extends TestCase
{

    protected Context $context;

    /**
     * Setup the test environment.
     *
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->context = Context::default([new DummyContext()]);
        parent::setUp();
    }

    /**
     * Test if the class can register an output formatter.
     *
     * @return void
     * @throws Exception
     */
    #[Test]
    public function it_registers_output_formatter()
    {
        $this->assertEquals('dummy', $this->context->resolve($this->makeVariable('dummy')));
        $this->assertEquals('dummy', $this->context->resolve($this->makeVariable('dummy', ['output-format' => 'dummy'])));

        $this->context->registerOutputFormatter(new DummyAnonymizationFormatter());

        $this->assertEquals('*****', $this->context->resolve($this->makeVariable('dummy', ['output-format' => 'dummy'])));
    }

    /**
     * Test if the class defaults to as-is formatter.
     *
     * @return void
     * @throws Exception
     */
    #[Test]
    public function it_defaults_to_as_is_formatter()
    {
        $this->assertEquals('dummy', $this->context->resolve($this->makeVariable('dummy')));
        $this->assertEquals('value', $this->context->resolve($this->makeVariable('dummy', ['key' => 'value', 'output-format' => 'example-non-existing-formatter'])));
    }

    /**
     * Get a new instance of the ParsedVariable class.
     *
     * @param  string $variable
     * @param  array  $arguments
     * @return ParsedVariable
     */
    protected function makeVariable(string $variable, array $arguments = []): ParsedVariable
    {
        return new ParsedVariable('[[dummy]]', $variable, $arguments);
    }
}