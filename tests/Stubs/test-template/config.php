<?php

return [

    // Base path of the project
    'basePath' => dirname(__DIR__, 2),

    'data' => [
        // Shared data
        'suffix' => 'example',
    ],

    'files' => [
        // File to be created
        [
            // Template file path relative to the template path
            'file_path' => 'Model.php.template',

            // Destination file path relative to the base path
            'directory_relative_path' => 'TestTmp/Models',
        ],
        [
            // Template file path relative to the template path
            'file_path' => 'helpers.php.template',

            // Destination file path relative to the base path
            'directory_relative_path' => 'TestTmp/Helpers',
        ],

        // ...More files...
    ],
];
