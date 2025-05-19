<?php
defined('ABSPATH') || exit;

function jlm_register_settings_page()
{
    add_options_page(
        'Job Listings Settings',
        'Job Listings',
        'manage_options',
        'jlm-settings',
        'jlm_settings_page_html'
    );
}

function jlm_settings_page_html()
{
?>
    <div class="wrap">
        <h1>Job Listings Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('jlm_settings_group');
            do_settings_sections('jlm-settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

function jlm_register_settings()
{
    // Register API settings
    register_setting('jlm_settings_group', 'jlm_enable_api', array(
        'type' => 'boolean',
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean'
    ));

    register_setting('jlm_settings_group', 'jlm_posts_per_page', array(
        'type' => 'integer',
        'default' => 10,
        'sanitize_callback' => 'absint'
    ));

    add_settings_section(
        'jlm_api_section',
        'API Settings',
        'jlm_api_section_callback',
        'jlm-settings'
    );

    add_settings_field(
        'jlm_enable_api',
        'Enable API Access',
        'jlm_enable_api_callback',
        'jlm-settings',
        'jlm_api_section'
    );

    add_settings_field(
        'jlm_posts_per_page',
        'Jobs Per Page',
        'jlm_posts_per_page_callback',
        'jlm-settings',
        'jlm_api_section'
    );
}

function jlm_api_section_callback()
{
    echo '<p>Configure the REST API settings for job listings.</p>';
}

function jlm_enable_api_callback()
{
    $enabled = get_option('jlm_enable_api', true);
?>
     <input type="hidden" name="jlm_enable_api" value="0">
    <label>
        <input type="checkbox" name="jlm_enable_api" value="1" <?php checked($enabled); ?>>
        Enable REST API access for job listings
    </label>
<?php
}

function jlm_posts_per_page_callback()
{
    $value = get_option('jlm_posts_per_page', 10);
?>
    <input type="number" name="jlm_posts_per_page" value="<?php echo esc_attr($value); ?>" min="1" max="100" class="small-text">
    <p class="description">Number of jobs to return in API responses</p>
<?php
}
