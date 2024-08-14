<?php

namespace MreeP\QuickTemplate\Tests\Unit\Context;

use Exception;
use MreeP\QuickTemplate\Context\Context;
use MreeP\QuickTemplate\Tests\Stubs\DummyContext;
use MreeP\QuickTemplate\Tests\TestCase;
use MreeP\QuickTemplate\Variables\ParsedVariable;
use PHPUnit\Framework\Attributes\Test;

/**
 * class ContextualVariableResolvingTest
 *
 * Test resolving variables in a given context
 */
final class ContextualVariableResolvingTest extends TestCase
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
        $this->context = Context::default();
        parent::setUp();
    }

    /**
     * Test if the class can register a variable resolver.
     *
     * @return void
     * @throws Exception
     */
    #[Test]
    public function it_registers_variable_resolver()
    {
        $this->assertNotEquals('dummy', $this->context->resolve($this->makeVariable('dummy')));

        $this->context->registerVariableResolver(new DummyContext());

        $this->assertEquals('dummy', $this->context->resolve($this->makeVariable('dummy')));
    }

    /**
     * Test if the class can register a variable resolver only once.
     *
     * @return void
     * @throws Exception
     */
    #[Test]
    public function it_registers_variable_resolver_once()
    {
        $this->expectException(Exception::class);
        $this->context->registerVariableResolver(new DummyContext());
        $this->context->registerVariableResolver(new DummyContext());
    }

    /**
     * Test if the class can resolve variables in a given context.
     *
     * @return void
     * @throws Exception
     */
    #[Test]
    public function it_resolves_variables_correctly()
    {
        $this->context->registerVariableResolver(new DummyContext());
        $this->assertEquals('dummy', $this->context->resolve($this->makeVariable('dummy')));
        $this->assertEquals('value', $this->context->resolve($this->makeVariable('dummy', ['key' => 'value'])));
    }

    /**
     * Test if the class replaces non-existing variables with an empty string.
     *
     * @return void
     */
    #[Test]
    public function it_replaces_non_existing_variables_correctly()
    {
        $this->assertEquals('', $this->context->resolve($this->makeVariable('dummy')));
        $this->assertEquals('', $this->context->resolve($this->makeVariable('some-random-non-existing-variable')));
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