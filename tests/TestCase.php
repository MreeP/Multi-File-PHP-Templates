<?php

namespace MreeP\QuickTemplate\Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * class TestCase
 *
 * base test case class
 */
abstract class TestCase extends PhpUnitTestCase
{

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}