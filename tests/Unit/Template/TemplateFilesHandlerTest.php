<?php

namespace MreeP\QuickTemplate\Tests\Unit\Template;

use MreeP\QuickTemplate\Context\Context;
use MreeP\QuickTemplate\Exceptions\Template\TemplateDirectoryDoesNotExistException;
use MreeP\QuickTemplate\Exceptions\Variables\VariableResolverAlreadyExists;
use MreeP\QuickTemplate\Helpers\FileSystemHelper;
use MreeP\QuickTemplate\Helpers\PathHelper;
use MreeP\QuickTemplate\Replacement\VariablesReplacer;
use MreeP\QuickTemplate\Template\TemplateFilesHandler;
use MreeP\QuickTemplate\Tests\Stubs\DummyContext;
use MreeP\QuickTemplate\Tests\TestCase;
use MreeP\QuickTemplate\Variables\VariableDetector;
use PHPUnit\Framework\Attributes\Test;

/**
 * class TemplateFilesHandlerTest
 *
 * Test template files handler.
 */
final class TemplateFilesHandlerTest extends TestCase
{

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        FileSystemHelper::removeDirectoryWithFiles(PathHelper::joinPaths(dirname(__DIR__, 2), 'TestTmp'));
        parent::tearDown();
    }

    /**
     * Test if handler throws error if path does not exist.
     *
     * @return void
     */
    #[Test]
    public function it_throws_error_if_path_does_not_exist()
    {
        $this->expectException(TemplateDirectoryDoesNotExistException::class);
        new TemplateFilesHandler(
            $this->getReplacer(),
            'non-existent-path',
            '',
        );
    }

    /**
     * Test if handler loads config correctly.
     *
     * @return void
     */
    #[Test]
    public function it_loads_config_correctly()
    {
        $handler = new TemplateFilesHandler(
            $this->getReplacer(),
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-template',
            ),
        );

        $this->assertIsArray($handler->getConfig());
        $this->assertArrayHasKey('basePath', $handler->getConfig());
        $this->assertEquals(dirname(__DIR__, 2), $handler->getConfigItem('basePath'));
        $this->assertArrayHasKey('files', $handler->getConfig());
        $this->assertCount(3, $handler->getConfigItem('files'));
    }

    /**
     * Test if handler creates template file in correct directory.
     *
     * @return void
     */
    #[Test]
    public function it_creates_template_file_in_correct_directory()
    {
        $handler = new TemplateFilesHandler(
            $this->getReplacer(),
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-template',
            ),
        );

        $handler->handle();

        $modelFilePath = PathHelper::joinPaths(
            dirname(__DIR__, 2),
            '/TestTmp/Models/Model.php',
        );

        $this->assertFileExists($modelFilePath);
        $this->assertFileIsReadable($modelFilePath);

        $modelFilePath = PathHelper::joinPaths(
            dirname(__DIR__, 2),
            '/TestTmp/Helpers/helpers.php',
        );

        $this->assertFileExists($modelFilePath);
        $this->assertFileIsReadable($modelFilePath);
    }

    /**
     * Test if handler creates template file with correct content.
     *
     * @return void
     */
    #[Test]
    public function it_creates_template_file_with_correct_content()
    {
        $handler = new TemplateFilesHandler(
            $this->getReplacer(),
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-template',
            ),
        );

        $handler->handle();

        $modelFilePath = PathHelper::joinPaths(
            dirname(__DIR__, 2),
            '/TestTmp/Models/Model.php',
        );

        $this->assertFileEquals(
            $modelFilePath,
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-handled-template/Model.php',
            ),
        );

        $helpersFilePath = PathHelper::joinPaths(
            dirname(__DIR__, 2),
            '/TestTmp/Helpers/helpers.php',
        );

        $this->assertFileEquals(
            $helpersFilePath,
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-handled-template/helpers.php',
            ),
        );
    }

    /**
     * Test if handler creates correct directories.
     *
     * @return void
     */
    #[Test]
    public function it_creates_correct_template_directories()
    {
        $handler = new TemplateFilesHandler(
            $this->getReplacer(),
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-template',
            ),
        );

        $handler->handle();

        $this->assertDirectoryExists(
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'TestTmp/Resources',
            ),
        );
    }

    /**
     * Test if handler creates file with variable in path.
     *
     * @return void
     */
    #[Test]
    public function it_creates_file_with_variable_in_path()
    {
        $handler = new TemplateFilesHandler(
            $this->getReplacer(),
            PathHelper::joinPaths(
                dirname(__DIR__, 2),
                'Stubs/test-template',
            ),
        );

        $handler->handle();

        $helpersFilePath = PathHelper::joinPaths(
            dirname(__DIR__, 2),
            '/TestTmp/Helpers/ExampleModule/helpers.php',
        );

        $this->assertFileExists($helpersFilePath);
        $this->assertFileIsReadable($helpersFilePath);
    }

    /**
     * Make dummy replacer for the handler.
     *
     * @return VariablesReplacer
     * @throws VariableResolverAlreadyExists
     */
    protected function getReplacer(): VariablesReplacer
    {
        return new VariablesReplacer(
            Context::default([new DummyContext()]),
            new VariableDetector(),
        );
    }
}