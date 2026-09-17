<?php


/**
 * METHOD: GET.
 * Endpoint to get a boletin by year and month
 * @param WP_REST_Request $request 
 */
function my_awesome_func($request)
{
    $year = intval($request['year']);
    $month = intval($request['month']);
    /**TODO: validate API */
    $query = get_newsletter_by_month_year($year, $month);
    $result = "";
    if ($query->have_posts()) {
        $query->the_post();
        if (function_exists('get_field')) {
            $href = get_field('source');
            $img_src = get_field('thumbnail');
            $result = array(
                'href' => $href,
                'img_src' => $img_src,
                'year' => $year,
                'month' => $month
            );
        }
    }
    wp_reset_postdata();
    return $result;
}

add_action('rest_api_init', function () {
    register_rest_route('bl-plugin/v1', '/boletines/(?P<year>\d+)/(?P<month>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'my_awesome_func',
    ));
});
