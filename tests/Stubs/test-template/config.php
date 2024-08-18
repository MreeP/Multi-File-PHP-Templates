<?php

return [

    // Base path of the project
    'base_path' => dirname(__DIR__, 2),

    // Output directory
    'output_directory' => 'TestTmp',

    'psr4' => [
        'TestTmp\\Tests' => 'Tests',
    ],

    // Shared data
    'data' => [
        'suffix' => 'example',
        'module' => 'ExampleModule',
    ],

    // Files to be created
    'files' => [
        [
            // Template file path relative to the template path
            'template_file_path' => 'Model.php.template',

            // Destination file path relative to the output directory
            'output_file_path' => 'Models/Model.php',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'helpers.php.template',

            // Destination file path relative to the output directory
            'output_file_path' => 'Helpers/helpers.php',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'helpers.php.template',

            // Destination file path relative to the output directory
            'output_file_path' => 'Helpers/[[ data key="module" ]]/helpers.php',
        ],
        [
            // Template file path relative to the template path
            'template_file_path' => 'TestCase.php.template',

            // Destination file path relative to the output directory
            'output_file_path' => 'Tests/TestCase.php',
        ],
        // ...More files...
    ],

    // Directories to be created relative to the output directory
    'directories' => [
        'Resources',
        // ...More directories...
    ],

    // Verbose mode
    'verbose' => false,
];
