<?php

namespace MreeP\QuickTemplate\Helpers;

/**
 * class Normalize
 *
 * class for normalizing data
 */
class Normalize
{

    /**
     * Method to normalize a string.
     *
     * @param  string $subject
     * @return string
     */
    public static function handle(string $subject): string
    {
        return preg_replace('/[^a-z_\-]+/', '', strtolower($subject));
    }
}