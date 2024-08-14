<?php

namespace MreeP\QuickTemplate\Tests\Unit\Variables;

use MreeP\QuickTemplate\Tests\TestCase;
use MreeP\QuickTemplate\Variables\VariableDetector;
use PHPUnit\Framework\Attributes\Test;

/**
 * class VariableDetectionTest
 *
 * Test variable matching pattern
 */
final class VariableDetectionTest extends TestCase
{

    protected VariableDetector $detector;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->detector = new VariableDetector();
        parent::setUp();
    }

    /**
     * Test if the class can detect variables in a given string.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_in_string()
    {
        $parsedVariable = $this->detector->detect('bc [[variableName]] def');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
    }

    /**
     * Test if the class can detect variables in a given string
     * where the variable is not surrounded by spaces.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_not_surrounded_by_spaces()
    {
        $parsedVariable = $this->detector->detect('abc[[variableName]]def');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
    }

    /**
     * Test if the class can detect variables with spaces around the variable name.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_spaces_around_variable_name()
    {
        $parsedVariable = $this->detector->detect('[[ variableName ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
    }

    /**
     * Test if the class can detect variables with spaces around the variable name.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_multiple_spaces_around_variable_name()
    {
        $parsedVariable = $this->detector->detect('[[   variableName       ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
    }

    /**
     * Test if the class can detect variables with flag arguments.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_flag_arguments()
    {
        $parsedVariable = $this->detector->detect('[[ variableName flagArg ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('flagArg'));
        $this->assertTrue($parsedVariable->getArguments()->getFlag('flagArg'));
    }

    /**
     * Test if the class can detect variables with multiple flag arguments.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_multiple_flag_arguments()
    {
        $parsedVariable = $this->detector->detect('[[ variableName flagArg1 flagArg2 ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('flagArg1'));
        $this->assertTrue($parsedVariable->getArguments()->getFlag('flagArg1'));
        $this->assertTrue($parsedVariable->getArguments()->has('flagArg2'));
        $this->assertTrue($parsedVariable->getArguments()->getFlag('flagArg2'));
    }

    /**
     * Test if the class can detect named variables.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_named_arguments()
    {
        $parsedVariable = $this->detector->detect('[[ variableName key="value" ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('key'));
        $this->assertEquals('value', $parsedVariable->getArguments()->getFlag('key'));
    }

    /**
     * Test if the class can detect named variables with multiple arguments.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_multiple_named_arguments()
    {
        $parsedVariable = $this->detector->detect('[[ variableName key1="value1" key2="value2" ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('key1'));
        $this->assertEquals('value1', $parsedVariable->getArguments()->getValue('key1'));
        $this->assertTrue($parsedVariable->getArguments()->has('key2'));
        $this->assertEquals('value2', $parsedVariable->getArguments()->getValue('key2'));
    }

    /**
     * Test if the class can detect mix of named and flag arguments.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_named_and_flag_arguments()
    {
        $parsedVariable = $this->detector->detect('[[ variableName key="value" flag ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('key'));
        $this->assertEquals('value', $parsedVariable->getArguments()->getValue('key'));
        $this->assertTrue($parsedVariable->getArguments()->has('flag'));
        $this->assertTrue($parsedVariable->getArguments()->getFlag('flag'));
    }

    /**
     * Test if the class can detect named variables with prefix and suffix.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variables_with_named_arguments_containing_prefix_and_suffix()
    {
        $parsedVariable = $this->detector->detect('[[ variableName key1="val]]ue" key2="va[[lue" ]]');

        $this->assertEquals('variableName', $parsedVariable->getVariable());
        $this->assertTrue($parsedVariable->getArguments()->has('key1'));
        $this->assertEquals('val]]ue', $parsedVariable->getArguments()->getValue('key1'));
        $this->assertTrue($parsedVariable->getArguments()->has('key2'));
        $this->assertEquals('va[[lue', $parsedVariable->getArguments()->getValue('key2'));
    }

    /**
     * Test if the class can detect multiple variables in a given string.
     *
     * @return void
     */
    #[Test]
    public function it_detects_multiple_variables_in_string()
    {
        $parsedVariables = $this->detector->detectAll('[[variableName1 fla="g"]] [[variableName2 flag]]');

        $this->assertCount(2, $parsedVariables);
        $this->assertEquals('variableName1', $parsedVariables[0]->getVariable());
        $this->assertEquals('g', $parsedVariables[0]->getArguments()->getValue('fla'));
        $this->assertEquals('variableName2', $parsedVariables[1]->getVariable());
        $this->assertTrue($parsedVariables[1]->getArguments()->getFlag('flag'));
    }

    /**
     * Test if the class can detect variable name with dashes.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variable_name_with_dashes()
    {
        $parsedVariables = $this->detector->detectAll('[[example-variable]]');

        $this->assertCount(1, $parsedVariables);
        $this->assertEquals('example-variable', $parsedVariables->first()->getVariable());
    }

    /**
     * Test if the class treats variables starting with dashes as invalid.
     *
     * @return void
     */
    #[Test]
    public function it_does_not_detect_variable_names_starting_with_dashes()
    {
        $parsedVariables = $this->detector->detectAll('[[-examplevariable]]');

        $this->assertCount(0, $parsedVariables);
    }

    /**
     * Test if the class can detect variable name with underscores.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variable_name_with_underscores()
    {
        $parsedVariables = $this->detector->detectAll('[[example_variable]]');

        $this->assertCount(1, $parsedVariables);
        $this->assertEquals('example_variable', $parsedVariables->first()->getVariable());
    }

    /**
     * Test if the class treats variables starting with underscores as invalid.
     *
     * @return void
     */
    #[Test]
    public function it_does_not_detect_variable_names_starting_with_underscores()
    {
        $parsedVariables = $this->detector->detectAll('[[_examplevariable]]');

        $this->assertCount(0, $parsedVariables);
    }
    
    /**
     * Test if the class can detect variable name with numbers.
     *
     * @return void
     */
    #[Test]
    public function it_detects_variable_name_with_numbers()
    {
        $parsedVariables = $this->detector->detectAll('[[example1variable2]]');

        $this->assertCount(1, $parsedVariables);
        $this->assertEquals('example1variable2', $parsedVariables->first()->getVariable());
    }

    /**
     * Test if the class treats variables starting with numbers as invalid.
     *
     * @return void
     */
    #[Test]
    public function it_does_not_detect_variable_names_starting_with_numbers()
    {
        $parsedVariables = $this->detector->detectAll('[[1examplevariable]]');

        $this->assertCount(0, $parsedVariables);
    }
}