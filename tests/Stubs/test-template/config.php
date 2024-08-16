<?php

return [

    // Base path of the project
    'basePath' => dirname(__DIR__, 2),

    // Shared data
    'data' => [
        'suffix' => 'example',
    ],

    // File to be created
    'files' => [
        [
            // Template file path relative to the template path
            'template_file_path' => 'Model.php.template',

            // Destination file path relative to the base path
            'directory_relative_path' => 'TestTmp/Models',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'helpers.php.template',

            // Destination file path relative to the base path
            'directory_relative_path' => 'TestTmp/Helpers',
        ],
        // ...More files...
    ],

    // Directory to be created
    'directories' => [
        'TestTmp/Resources',
        // ...More directories...
    ],

    // Verbose mode
    'verbose' => false,
];
