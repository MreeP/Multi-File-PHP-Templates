<?php

namespace MreeP\QuickTemplate\Exceptions\Template;

/**
 * class TemplateDirectoryDoesNotExistException
 *
 * Exception for when the template directory does not exist.
 */
class TemplateDirectoryDoesNotExistException extends TemplateException
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $message
     */
    public function __construct(string $message = 'The template directory does not exist.')
    {
        parent::__construct($message);
    }
}