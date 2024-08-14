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
     * Handle the files in the given directory.
     *
     * @return void
     */
    protected function handleFiles(): void
    {
        foreach ($this->config['files'] as $file) {
            $this->handleFile(
                $this->templatePath($file['file_path']),
                $this->basePath($file['directory_relative_path'], $this->getOutputFileName($file['file_path'])),
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
        $content = FileSystemHelper::getFileContents($inputFile);
        $result = $this->replacer->handleReplacement($content, $file);
        FileSystemHelper::putFileContents($outputFile, $result, true);
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
            $this->getConfigItem('basePath'),
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
}