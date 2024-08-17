<?php

namespace MreeP\QuickTemplate\Variables;

use MreeP\QuickTemplate\Helpers\Collection;

/**
 * class VariableDetector
 *
 * class for detecting variables in a given context
 */
class VariableDetector
{

    /**
     * The prefix for the variable.
     *
     * @var string
     */
    public static string $prefix = '[[';

    /**
     * The suffix for the variable.
     *
     * @var string
     */
    public static string $suffix = ']]';

    /**
     * Detect the first variables in the given text.
     *
     * @param  string $text
     * @return null|ParsedVariable
     */
    public function detect(string $text): ?ParsedVariable
    {
        preg_match(
            $this->makePattern(),
            $text,
            $matches,
        );

        return new ParsedVariable(
            $matches['raw'] ?? '',
            $matches['variable'] ?? '',
            $this->parseArguments($matches['arguments'] ?? ''),
        );
    }

    /**
     * Detect all variables in the given text.
     *
     * @param  string $text
     * @return Collection
     */
    public function detectAll(string $text): Collection
    {
        preg_match_all(
            $this->makePattern(),
            $text,
            $matches,
        );

        $parsedVariables = [];

        for ($i = 0; $i < count($matches[0]); $i++) {
            $parsedVariables[] = new ParsedVariable(
                $matches['raw'][$i],
                $matches['variable'][$i],
                $this->parseArguments($matches['arguments'][$i]),
            );
        }

        return Collection::make($parsedVariables);
    }

    /**
     * Parse the arguments for the variable.
     *
     * @param  string $arguments
     * @return array
     */
    protected function parseArguments(string $arguments): array
    {
        $parsedArgs = [];

        while (preg_match($this->makeNamedVariablePattern(), $arguments, $arg)) {
            $arguments = str_replace($arg[0], '', $arguments);
            $parsedArgs[$arg['name']] = $arg['value'];
        }

        while (preg_match($this->makeFlagVariablePattern(), $arguments, $arg)) {
            $arguments = str_replace($arg[0], '', $arguments);
            $parsedArgs[$arg['flag']] = true;
        }

        return $parsedArgs;
    }

    /**
     * The pattern for the variable detection.
     *
     * @return string
     */
    protected function makePattern(): string
    {
        $variable = '(?<variable>[a-zA-Z][\w_\-]+)';
        $arguments = "(?<arguments>(?: +(?:[a-zA-Z][\w\-]*)| +(?:[a-zA-Z][\w\-]*=\"(?:[^\"\n\\\\]|(?:\\\\\"))*\"))+)?";
        $prefix = $this->getPatternPrefix();
        $suffix = $this->getPatternSuffix();

        return '/(?<raw>' . $prefix . ' *' . $variable . $arguments . ' *' . $suffix . ')/';
    }

    /**
     * Get the prefix for the variable.
     *
     * @return string
     */
    protected function getPatternPrefix(): string
    {
        return preg_quote(static::$prefix, '/');
    }

    /**
     * Get the suffix for the variable.
     *
     * @return string
     */
    protected function getPatternSuffix(): string
    {
        return preg_quote(static::$suffix, '/');
    }

    /**
     * The pattern for the named variable.
     *
     * @return string
     */
    protected function makeNamedVariablePattern(): string
    {
        return '/(?<name>[a-zA-Z][\w\-]*)=("?)(?<value>(?:[^"\n\\\\]|(?:\\\\"))*)(?2)/';
    }

    /**
     * The pattern for the flag variable.
     *
     * @return string
     */
    protected function makeFlagVariablePattern(): string
    {
        return '/(?<flag>[a-zA-Z][\w\-]*)/';
    }
}
