<?php
defined('ABSPATH') || exit;

function jlm_register_job_listing_cpt()
{
    $labels = array(
        'name' => 'Job Listings',
        'singular_name' => 'Job Listing',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Job',
        'edit_item' => 'Edit Job',
        'new_item' => 'New Job',
        'view_item' => 'View Job',
        'search_items' => 'Search Jobs',
        'not_found' => 'No jobs found',
        'menu_name' => 'Job Listings',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'jobs'),
        'capability_type' => 'post',
        'menu_position' => 5,
    );

    register_post_type('job_listing', $args);

    // Register meta fields
    $meta_fields = array(
        'company_name' => array(
            'type' => 'string',
            'description' => 'Company Name',
            'single' => true,
        ),
        'job_location' => array(
            'type' => 'string',
            'description' => 'Job Location',
            'single' => true,
        ),
        'salary_range' => array(
            'type' => 'number',
            'description' => 'Salary Range',
            'single' => true,
        ),
        'application_deadline' => array(
            'type' => 'string',
            'description' => 'Application Deadline',
            'single' => true,
        )
    );

    foreach ($meta_fields as $field_name => $args) {
        register_post_meta('job_listing', $field_name, array(
            'type' => $args['type'],
            'description' => $args['description'],
            'single' => $args['single'],
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            }
        ));
    }
}
