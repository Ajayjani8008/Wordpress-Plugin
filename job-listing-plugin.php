<?php

/**
 * Plugin Name: Job Listings Manager
 * Description: A simple job listings manager with CPT, meta boxes and REST API.
 * Version: 1.0
 * Author: Encircle pvt  ltd
 * Auther URI: https://encircletechnologies.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: job-listing-manager
 */


defined('ABSPATH') || exit;

// Define plugin constants

define('JLM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('JLM_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once JLM_PLUGIN_DIR . 'includes/cpt-job-listing.php';
require_once JLM_PLUGIN_DIR . 'includes/meta-boxes.php';
require_once JLM_PLUGIN_DIR . 'includes/settings.php';
require_once JLM_PLUGIN_DIR . 'includes/rest-api.php';

// Init
add_action('init', 'jlm_register_job_listing_cpt');
add_action('add_meta_boxes', 'jlm_register_meta_boxes');
add_action('save_post', 'jlm_save_job_meta', 10, 2);
add_action('admin_menu', 'jlm_register_settings_page');
add_action('admin_init', 'jlm_register_settings');
add_action('rest_api_init', 'jlm_register_rest_routes');

// Register shortcode
add_shortcode('job_listings', 'jlm_job_listings_shortcode');

function jlm_job_listings_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'posts_per_page' => get_option('jlm_posts_per_page', 10),
        'orderby' => 'date',
        'order' => 'DESC',
    ), $atts);

    $args = array(
        'post_type' => 'job_listing',
        'posts_per_page' => $atts['posts_per_page'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'post_status' => 'publish'
    );

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        $output .= '<div class="job-listings">';

        while ($query->have_posts()) {
            $query->the_post();
            $company_name = get_post_meta(get_the_ID(), 'company_name', true);
            $location = get_post_meta(get_the_ID(), 'job_location', true);
            $salary = get_post_meta(get_the_ID(), 'salary_range', true);
            $deadline = get_post_meta(get_the_ID(), 'application_deadline', true);

            $output .= '<div class="job-listing">';
            if (has_post_thumbnail()) {
                $output .= '<div class="job-image">' . get_the_post_thumbnail(get_the_ID(), 'thumbnail') . '</div>';
            }
            $output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            $output .= '<div class="job-meta">';
            if ($company_name) {
                $output .= '<p class="company"><strong>Company:</strong> ' . esc_html($company_name) . '</p>';
            }
            if ($location) {
                $output .= '<p class="location"><strong>Location:</strong> ' . esc_html($location) . '</p>';
            }
            if ($salary) {
                $output .= '<p class="salary"><strong>Salary Range:</strong> ' . esc_html($salary) . '</p>';
            }
            if ($deadline) {
                $output .= '<p class="deadline"><strong>Application Deadline:</strong> ' . esc_html($deadline) . '</p>';
            }
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';
        wp_reset_postdata();
    } else {
        $output = '<p>No job listings found.</p>';
    }

    return $output;
}

// add CSS for job listings display(just for demo purposes)
// This should be moved to a separate CSS file in a real-world scenario
add_action('wp_head', 'jlm_job_listings_css');

function jlm_job_listings_css()
{
?>
    <style>
        .job-listings {
            max-width: 1200px;
            margin: 2em auto;
        }

        .job-listing {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
        }

        .job-listing:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .job-listing h3 {
            margin: 0 0 10px 0;
        }

        .job-listing h3 a {
            text-decoration: none;
            color: #333;
        }

        .job-meta {
            color: #666;
        }

        .job-meta p {
            margin: 5px 0;
        }

        .job-image {
            float: right;
            margin: 0 0 20px 20px;
        }

        .job-image img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
        }
    </style>
<?php
}

// Add activation/deactivation hooks for rewrite rules
register_activation_hook(__FILE__, 'jlm_plugin_activate');
register_deactivation_hook(__FILE__, 'jlm_plugin_deactivate');

function jlm_plugin_activate()
{
    jlm_register_job_listing_cpt();
    flush_rewrite_rules();
}

function jlm_plugin_deactivate()
{
    flush_rewrite_rules();
}
