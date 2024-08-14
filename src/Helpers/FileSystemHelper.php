<?php

namespace MreeP\QuickTemplate\Helpers;

/**
 * class FileSystemHelper
 *
 * class for handling file system operations
 */
class FileSystemHelper
{

    /**
     * Check if the given path exists.
     *
     * @param  string $path
     * @return bool
     */
    public static function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * Check if the given path is a directory.
     *
     * @param  string $path
     * @return bool
     */
    public static function isDir(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * Check if the given path is a directory and exists.
     *
     * @param  string $path
     * @return bool
     */
    public static function dirExists(string $path): bool
    {
        return static::exists($path)
            && static::isDir($path);
    }

    /**
     * Get the contents of the given file.
     *
     * @param  string $file
     * @return string
     */
    public static function getFileContents(string $file): string
    {
        return file_get_contents($file);
    }

    /**
     * Put the given contents into the given file.
     *
     * @param  string $filePath
     * @param  string $contents
     * @param  bool   $force
     * @return void
     */
    public static function putFileContents(string $filePath, string $contents, bool $force = false): void
    {
        if ($force) {
            $parts = explode('/', $filePath);
            array_pop($parts);
            $dir = implode('/', $parts);

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }

        file_put_contents($filePath, $contents);
    }

    /**
     * Remove the given directory with all its files.
     *
     * @param  string $path
     * @return bool
     */
    public static function removeDirectoryWithFiles(string $path): bool
    {
        if (!is_dir($path)) {
            return false;
        }

        foreach (array_diff(scandir($path), ['.', '..']) as $file) {
            $full = PathHelper::joinPaths($path, $file);

            if (is_dir($full)) {
                static::removeDirectoryWithFiles($full);
            } else {
                unlink($full);
            }
        }

        return rmdir($path);
    }
}