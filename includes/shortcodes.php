<?php

function boletines_latest_shortcode()
{
    $query = get_latest_newsletter();
    ob_start();
    include plugin_dir_path(__DIR__) . 'templates/latest.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function boletines_archive_shortcode()
{
    $query = get_newsletters();
    ob_start();
    include plugin_dir_path(__DIR__) . 'templates/archive.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function boletines_search_shortcode()
{
    $query = get_newsletter_by_month_year(2, 2026);
    ob_start();
    include plugin_dir_path(__DIR__) . 'templates/search.php';
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode(
    'latest_newsletter',
    'boletines_latest_shortcode'
);
add_shortcode('newsletters', 'boletines_archive_shortcode');
add_shortcode('search_newsletter', 'boletines_search_shortcode');
