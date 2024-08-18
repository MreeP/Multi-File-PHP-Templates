<?php

namespace MreeP\QuickTemplate\Template;

use MreeP\QuickTemplate\Exceptions\Template\TemplateDirectoryDoesNotExistException;
use MreeP\QuickTemplate\Helpers\FileSystemHelper;
use MreeP\QuickTemplate\Helpers\PathHelper;
use MreeP\QuickTemplate\Replacement\VariablesReplacer;

/**
 * class TemplateFilesHandler
 *
 * class for handling the process of using the template files
 */
class TemplateFilesHandler
{

    protected array $config;

    /**
     * Create a new instance of the class.
     *
     * @param  VariablesReplacer $replacer
     * @param  string            $templatePath
     * @param  string            $templateExtension
     */
    public function __construct(
        protected VariablesReplacer $replacer,
        protected string            $templatePath,
        protected string            $templateExtension = '.template',
    )
    {
        $this->ensureDirectoryExists($this->templatePath);
        $this->setupHandler();
    }

    /**
     * Ensure the given path is a directory.
     *
     * @param  string $templatePath
     * @return void
     */
    protected function ensureDirectoryExists(string $templatePath): void
    {
        if (!FileSystemHelper::dirExists($templatePath)) {
            throw new TemplateDirectoryDoesNotExistException();
        }
    }

    /**
     * Handle the process of using the template files.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->handleFiles();
        $this->handleDirectories();
    }

    /**
     * Load configuration and prepare for template creation.
     *
     * @return void
     */
    protected function setupHandler(): void
    {
        $configPath = $this->templatePath . '/config.php';

        if (
            FileSystemHelper::exists($configPath)
            && is_array($config = include $configPath)
        ) {
            $this->setConfig($config);
        }
    }

    /**
     * Handle the files.
     *
     * @return void
     */
    protected function handleFiles(): void
    {
        foreach ($this->config['files'] ?? [] as $file) {
            $this->handleFile(
                $this->templatePath($file['template_file_path']),
                $this->outputPath($this->handleReplacement($file['output_file_path'])),
                $file,
            );
        }
    }

    /**
     * Handle the given file.
     *
     * @param  string $inputFile
     * @param  string $outputFile
     * @param  array  $file
     * @return void
     */
    protected function handleFile(string $inputFile, string $outputFile, array $file = []): void
    {
        FileSystemHelper::putFileContents(
            $outputFile,
            $this->handleReplacement(
                FileSystemHelper::getFileContents($inputFile),
                array_merge(
                    [
                        'base_path' => $this->getConfigItem('base_path'),
                        'output_directory' => $this->getConfigItem('output_directory'),
                        'psr4' => $this->getConfigItem('psr4', []),
                    ],
                    $file,
                ),
            ),
            true,
        );

        if ($this->isVerbose()) {
            echo "File created: $outputFile\n";
        }
    }

    /**
     * Handle the directories.
     *
     * @return void
     */
    protected function handleDirectories(): void
    {
        foreach ($this->config['directories'] ?? [] as $directory) {
            $this->handleDirectory($directory);
        }
    }

    /**
     * Handle the given directory.
     *
     * @param  string $directory
     * @return void
     */
    protected function handleDirectory(string $directory): void
    {
        $directory = $this->outputPath($this->handleReplacement($directory));

        FileSystemHelper::makeDirectory($directory);

        if ($this->isVerbose()) {
            echo "Directory created: {$directory}\n";
        }
    }

    /**
     * Handle the replacement.
     *
     * @param  string $text
     * @param  array  $file
     * @return string
     */
    protected function handleReplacement(string $text, array $file = []): string
    {
        return $this->replacer->handleReplacement($text, $file);
    }

    /**
     * Return path relative to the basePath.
     *
     * @param  string $path
     * @return string
     */
    protected function baseRelativePath(string $path): string
    {
        return trim(
            str_replace($this->basePath(), '', $path),
            DIRECTORY_SEPARATOR,
        );
    }

    /**
     * Make the path relative to the output path.
     *
     * @param  ...$path
     * @return string
     */
    protected function outputPath(...$path): string
    {
        return $this->basePath(
            $this->getConfigItem('output_directory', ''),
            ...$path,
        );
    }

    /**
     * Make the path relative to the base path.
     *
     * @param  ...$path
     * @return string
     */
    protected function basePath(...$path): string
    {
        return PathHelper::joinPaths(
            $this->getConfigItem('base_path'),
            ...$path,
        );
    }

    /**
     * Make the path relative to the template path.
     *
     * @param  ...$path
     * @return string
     */
    protected function templatePath(...$path): string
    {
        return PathHelper::joinPaths(
            $this->templatePath,
            ...$path,
        );
    }

    /**
     * Get the output file name.
     *
     * @param  string $templateName
     * @return string
     */
    protected function getOutputFileName(string $templateName): string
    {
        return str_replace($this->templateExtension, '', $templateName);
    }

    /**
     * Get the configuration item.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getConfigItem(string $key, mixed $default = null): mixed
    {
        $current = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!array_key_exists($segment, $current)) {
                return $default;
            }

            $current = $current[$segment];
        }

        return $current;
    }

    /**
     * Get the configuration.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set the configuration.
     *
     * @param  array $config
     * @return TemplateFilesHandler
     */
    protected function setConfig(array $config): static
    {
        $this->config = $config;
        $this->replacer->setContextData($config['data'] ?? []);
        return $this;
    }

    /**
     * Check if the verbose mode is enabled.
     *
     * @return mixed
     */
    protected function isVerbose(): mixed
    {
        return $this->getConfigItem('verbose', true);
    }
}