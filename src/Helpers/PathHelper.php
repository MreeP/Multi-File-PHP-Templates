<?php

namespace MreeP\QuickTemplate\Helpers;

/**
 * class PathHelper
 *
 * class for handling path operations
 */
class PathHelper
{

    /**
     * Join paths together.
     *
     * @param $basePath
     * @param ...$paths
     * @return string
     */
    public static function joinPaths($basePath, ...$paths): string
    {
        foreach ($paths as $index => $path) {
            if (empty($path) && $path !== '0') {
                unset($paths[$index]);
            } else {
                $paths[$index] = DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
            }
        }

        return $basePath . implode('', $paths);
    }
}