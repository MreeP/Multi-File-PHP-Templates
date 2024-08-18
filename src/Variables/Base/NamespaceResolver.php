<?php

namespace MreeP\QuickTemplate\Variables\Base;

use MreeP\QuickTemplate\Variables\ParsedVariableArguments;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class NamespaceResolver
 *
 * Resolver for the namespace variable.
 */
class NamespaceResolver implements VariableResolver
{

    /**
     * Get the name of the resolver.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'namespace';
    }

    /**
     * Resolve the variable.
     *
     * @param  ParsedVariableArguments $arguments
     * @param  array                   $data
     * @param  array                   $file
     * @return string
     */
    public function resolve(ParsedVariableArguments $arguments, array $data, array $file = []): string
    {
        return $file['namespace'] ?? $this->resolvePsr4(
            $this->makeNamespace($file),
            $file['psr4'] ?? [],
        );
    }

    /**
     * Resolve the PSR-4 namespace.
     *
     * @param  string $namespace
     * @param  array  $psr4
     * @return string
     */
    protected function resolvePsr4(string $namespace, array $psr4): string
    {
        foreach ($psr4 as $prefix => $path) {
            if (str_starts_with($namespace, $prefix)) {
                return $path . str_replace($prefix, '', $namespace);
            }
        }

        return $namespace;
    }

    /**
     * Make the namespace.
     *
     * @param  array $file
     * @return string
     */
    protected function makeNamespace(array $file): string
    {
        $pathSegments = explode(DIRECTORY_SEPARATOR, $this->getOutputFilePath($file));
        $directory = array_slice($pathSegments, 0, -1);

        return trim(
            implode('\\', $directory),
            '\\',
        );
    }

    /**
     * Get the output file path.
     *
     * @param  array $file
     * @return string
     */
    protected function getOutputFilePath(array $file): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $file['output_directory'],
                $file['output_file_path'],
            ],
        );
    }
}