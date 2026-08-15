<?php

function boletines_enqueue_assets()
{
    $css_file = BOLETINES_PLUGIN_PATH . 'assets/css/boletines.css';
    $js_file  = BOLETINES_PLUGIN_PATH . 'assets/js/boletines.js';

    wp_enqueue_style(
        'boletines-styles',
        BOLETINES_PLUGIN_URL . 'assets/css/boletines.css',
        [],
        filemtime($css_file)
    );

    wp_enqueue_script(
        'boletines-scripts',
        BOLETINES_PLUGIN_URL . 'assets/js/boletines.js',
        [],
        filemtime($js_file),
        true
    );
}

add_action(
    'wp_enqueue_scripts',
    'boletines_enqueue_assets'
);
