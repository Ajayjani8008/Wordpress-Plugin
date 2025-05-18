<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$args = [
    'post_type' => 'job_listing',
    'numberposts' => -1,
    'post_status' => 'any',
];

$jobs = get_posts($args);

foreach ($jobs as $job) {
    wp_delete_post($job->ID, true);
}

delete_option('jlm_default_location');