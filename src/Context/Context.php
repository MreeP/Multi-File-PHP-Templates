<?php

namespace MreeP\QuickTemplate\Context;

use MreeP\QuickTemplate\Exceptions\Variables\VariableResolverAlreadyExists;
use MreeP\QuickTemplate\Formatters\AsIsFormatter;
use MreeP\QuickTemplate\Formatters\CamelCaseFormatter;
use MreeP\QuickTemplate\Formatters\OutputFormatter;
use MreeP\QuickTemplate\Formatters\PascalCaseFormatter;
use MreeP\QuickTemplate\Formatters\TrimFormatter;
use MreeP\QuickTemplate\Helpers\Normalize;
use MreeP\QuickTemplate\Variables\Base\DataResolver;
use MreeP\QuickTemplate\Variables\Base\NameResolver;
use MreeP\QuickTemplate\Variables\Base\NamespaceResolver;
use MreeP\QuickTemplate\Variables\Base\NonExistingResolver;
use MreeP\QuickTemplate\Variables\ParsedVariable;
use MreeP\QuickTemplate\Variables\VariableResolver;

/**
 * class Context
 *
 * class for storing and accessing context data
 */
class Context
{

    protected array $data = [];

    protected array $outputFormatters = [];

    protected array $variableResolvers = [];

    /**
     * Static method to create a new instance of the class.
     *
     * @param  array $resolvers
     * @param  array $formatters
     * @return static
     */
    public static function default(array $resolvers = [], array $formatters = []): static
    {
        $instance = new static();

        foreach (static::getDefaultResolvers() as $resolver) {
            $instance->registerVariableResolver($resolver);
        }

        foreach ($resolvers as $resolver) {
            $instance->registerVariableResolver($resolver);
        }

        foreach (static::getDefaultFormatters() as $formatter) {
            $instance->registerOutputFormatter($formatter);
        }

        foreach ($formatters as $formatter) {
            $instance->registerOutputFormatter($formatter);
        }

        return $instance;
    }

    /**
     * Returns the default variable resolvers array.
     *
     * @return VariableResolver[]
     */
    protected static function getDefaultResolvers(): array
    {
        return [
            new DataResolver(),
            new NonExistingResolver(),
            new NamespaceResolver(),
            new NameResolver(),
        ];
    }

    /**
     * Returns the default output formatters array.
     *
     * @return OutputFormatter[]
     */
    protected static function getDefaultFormatters(): array
    {
        return [
            new AsIsFormatter(),
            new TrimFormatter(),
            new CamelCaseFormatter(),
            new PascalCaseFormatter(),
        ];
    }

    /**
     * Set a new variable.
     *
     * @param  ParsedVariable $variable
     * @param  array          $file
     * @return string
     */
    public function resolve(ParsedVariable $variable, array $file = []): string
    {
        return $this->formatOutput(
            $variable,
            $this->getVariableResolver($variable->getVariable())->resolve($variable->getArguments(), $this->data, $file),
        );
    }

    /**
     * Set the data for the context.
     *
     * @param  array $data
     * @return Context
     */
    public function mergeData(array $data): static
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Register a new variable resolver.
     *
     * @param  VariableResolver $variableResolver
     * @return void
     * @throws VariableResolverAlreadyExists
     */
    public function registerVariableResolver(VariableResolver $variableResolver): void
    {
        if ($this->hasVariableResolver($variableResolver->getName())) {
            throw new VariableResolverAlreadyExists('Variable resolver already exists.');
        }

        $this->variableResolvers[Normalize::handle($variableResolver->getName())] = $variableResolver;
    }

    /**
     * Determine if the context has a variable resolver.
     *
     * @param  string $name
     * @return bool
     */
    protected function hasVariableResolver(string $name): bool
    {
        return array_key_exists(Normalize::handle($name), $this->variableResolvers);
    }

    /**
     * Get the variable resolver.
     *
     * @param  string $name
     * @return ?VariableResolver
     */
    protected function getVariableResolver(string $name): ?VariableResolver
    {
        if (!$this->hasVariableResolver($name)) {
            return new NonExistingResolver();
        }

        return $this->variableResolvers[Normalize::handle($name)];
    }

    /**
     * Format the output.
     *
     * @param  ParsedVariable $variable
     * @param  string         $content
     * @return string
     */
    protected function formatOutput(ParsedVariable $variable, string $content): string
    {
        $formatter = $this->getOutputFormatter($variable->getArguments()->getValue('output-format', (new AsIsFormatter())->name()));
        return $formatter->format($content);
    }

    /**
     * Register a new output formatter.
     *
     * @param  OutputFormatter $outputFormatter
     * @return void
     */
    public function registerOutputFormatter(OutputFormatter $outputFormatter): void
    {
        $this->outputFormatters[Normalize::handle($outputFormatter->name())] = $outputFormatter;
    }

    /**
     * Determine if the context has an output formatter.
     *
     * @param  string $name
     * @return bool
     */
    protected function hasOutputFormatter(string $name): bool
    {
        return array_key_exists(Normalize::handle($name), $this->outputFormatters);
    }

    /**
     * Get the output formatter.
     *
     * @param  string $name
     * @return ?OutputFormatter
     */
    protected function getOutputFormatter(string $name): ?OutputFormatter
    {
        if (!$this->hasOutputFormatter($name)) {
            return new AsIsFormatter();
        }

        return $this->outputFormatters[Normalize::handle($name)];
    }
}