<?php
defined('ABSPATH') || exit;

function jlm_register_rest_routes()
{
    register_rest_route('jobs/v1', '/listings', array(
        'methods' => 'GET',
        'callback' => 'jlm_get_job_listings',
       'permission_callback' => function () {
            if (!get_option('jlm_enable_api', true)) {
                return new WP_Error('api_disabled', __('API access is disabled.', 'text-domain'), array('status' => 403));
            }
            return true;
        }
    ));
}

function jlm_get_job_listings($request)
{
    $posts_per_page = get_option('jlm_posts_per_page', 10);

    $args = array(
        'post_type' => 'job_listing',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $jobs = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $jobs[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'company_name' => get_post_meta(get_the_ID(), 'company_name', true),
                'location' => get_post_meta(get_the_ID(), 'job_location', true),
                'salary_range' => get_post_meta(get_the_ID(), 'salary_range', true),
                'application_deadline' => get_post_meta(get_the_ID(), 'application_deadline', true),
                'permalink' => get_permalink(),
                'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full')
            );
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($jobs);
}
