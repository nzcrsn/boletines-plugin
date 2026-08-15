<?php

/**
 * Plugin Name: Boletines
 * Description: Newsletter management and display system.
 * Version: 1.0.0
 * Author: nzcrsn
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BOLETINES_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BOLETINES_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once BOLETINES_PLUGIN_PATH . 'includes/queries.php';
require_once BOLETINES_PLUGIN_PATH . 'includes/shortcodes.php';
require_once BOLETINES_PLUGIN_PATH . 'includes/assets.php';
require_once BOLETINES_PLUGIN_PATH . 'includes/api.php';
