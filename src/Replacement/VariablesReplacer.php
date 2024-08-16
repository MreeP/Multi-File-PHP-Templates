<?php

namespace MreeP\QuickTemplate\Replacement;

use MreeP\QuickTemplate\Context\Context;
use MreeP\QuickTemplate\Variables\ParsedVariable;
use MreeP\QuickTemplate\Variables\VariableDetector;

/**
 * class StringVariablesReplacer
 *
 * class for replacing variables in a given string
 */
class VariablesReplacer
{

    /**
     * Create a new instance of the class.
     *
     * @param  Context          $context
     * @param  VariableDetector $detector
     */
    public function __construct(
        protected Context          $context,
        protected VariableDetector $detector,
    ) {}

    /**
     * Replace all variables in the given text.
     *
     * @param  string $text
     * @param  array  $file
     * @return string
     */
    public function handleReplacement(string $text, array $file = []): string
    {
        $this->detector->detectAll($text)->each(function (ParsedVariable $variable) use (&$text, $file) {
            $text = str_replace(
                $variable->getRaw(),
                $this->context->resolve($variable, $file),
                $text,
            );
        });

        return $text;
    }

    /**
     * Set the context data.
     *
     * @param  array $data
     * @return self
     */
    public function setContextData(array $data): self
    {
        $this->context->mergeData($data);
        return $this;
    }
}