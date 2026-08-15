<?php

/**
 * Get latest newsletter query.
 *
 * @return WP_Query
 */
function get_latest_newsletter()
{
    $args = array(
        'post_type' => 'newsletters',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    return new WP_Query($args);
}

/**
 * Get newsletters by month query.
 *
 * @return WP_Query
 */
function get_newsletter_by_month($atts = [])
{
    $current_year = (int) date('Y');
    $month = (int) $atts['month'];
    $args = array(
        'post_type' => 'newsletters',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'date_query' => array(
            array(
                'year' => $current_year,
                'month' => $month,
            ),
        ),

    );
    return new WP_Query($args);
}

/**
 * Get newsletters by month and year query.
 *
 * @return WP_Query
 */
function get_newsletter_by_month_year(int $year, int $month)
{
    $args = array(
        'post_type' => 'newsletters',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'date_query' => array(
            array(
                'year' => $year,
                'month' => $month,
            ),
        ),

    );
    return new WP_Query($args);
}

/**
 * Get newsletters query.
 *
 * @return WP_Query
 */
function get_newsletters()
{
    $current_year = (int) date('Y');
    $current_month = (int) date('m');
    $args = array(
        'post_type' => 'newsletters',
        'posts_per_page' => $current_month - 1,
        'post_status' => 'publish',
        'date_query' => array(
            array(
                'year' => $current_year,
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => 1, //

    );

    return new WP_Query($args);
}
