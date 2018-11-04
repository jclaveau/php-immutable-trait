<?php
/**
 * This file is executed before every run of the tests
 */

// Avoid ellipsis of xdebug dumps
ini_set('xdebug.max_nesting_level', 10000);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

require_once __DIR__ . '/AbstractTest.php';

if (extension_loaded('xhprof')) {
    // ini_set('xhprof.output_dir', __DIR__ . '/profile');
    if (($profile_dir = ini_get('xhprof.output_dir')) && !file_exists($profile_dir))
        mkdir( ini_get('xhprof.output_dir'), 0777, true );
}

// require __DIR__ . '/../../xhgui/external/header.php';
