<?php

namespace MreeP\QuickTemplate\Exceptions\Template;

/**
 * class TemplateDataKeyDoesNotExist
 *
 * Exception for when a template data key does not exist.
 */
class TemplateDataKeyDoesNotExist extends TemplateException
{

    /**
     * Create a new instance of the class.
     *
     * @param  string $message
     */
    public function __construct(string $message = 'Template data key does not exist.')
    {
        parent::__construct($message);
    }
}