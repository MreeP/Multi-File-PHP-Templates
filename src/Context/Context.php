<?php

namespace MreeP\QuickTemplate\Context;

use MreeP\QuickTemplate\Exceptions\Variables\VariableResolverAlreadyExists;
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

    protected array $variableResolvers = [];

    /**
     * Static method to create a new instance of the class.
     *
     * @param  array $resolvers
     * @return static
     * @throws VariableResolverAlreadyExists
     */
    public static function default(array $resolvers = []): static
    {
        $instance = new static();

        foreach (static::getDefaultResolvers() as $resolver) {
            $instance->registerVariableResolver($resolver);
        }

        foreach ($resolvers as $resolver) {
            $instance->registerVariableResolver($resolver);
        }

        return $instance;
    }

    /**
     * Returns the default resolvers array.
     *
     * @return NonExistingResolver[]
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
     * Set a new variable.
     *
     * @param  ParsedVariable $variable
     * @param  array          $file
     * @return string
     */
    public function resolve(ParsedVariable $variable, array $file = []): string
    {
        return $this->getVariableResolver($variable->getVariable())
            ->resolve($variable->getArguments(), $this->data, $file);
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
}