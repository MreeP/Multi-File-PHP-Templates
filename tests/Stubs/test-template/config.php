<?php

return [

    // Base path of the project
    'basePath' => dirname(__DIR__, 2),

    // Shared data
    'data' => [
        'suffix' => 'example',
        'module' => 'ExampleModule',
    ],

    // File to be created
    'files' => [
        [
            // Template file path relative to the template path
            'template_file_path' => 'Model.php.template',

            // Destination file path relative to the base path
            'output_file_path' => 'TestTmp/Models/Model.php',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'helpers.php.template',

            // Destination file path relative to the base path
            'output_file_path' => 'TestTmp/Helpers/helpers.php',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'helpers.php.template',

            // Destination file path relative to the base path
            'output_file_path' => 'TestTmp/Helpers/[[ data key="module" ]]/helpers.php',
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
