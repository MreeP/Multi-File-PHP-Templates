<?php

namespace MreeP\QuickTemplate\Exceptions\Template;

use RuntimeException;

/**
 * class TemplateException
 *
 * Exception for template errors.
 */
class TemplateException extends RuntimeException
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $message
     */
    public function __construct(string $message = 'An error occurred with the template.')
    {
        parent::__construct($message);
    }
}