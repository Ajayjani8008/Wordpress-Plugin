<?php
defined( 'ABSPATH' ) || exit;

function jlm_register_meta_boxes() {
    add_meta_box(
        'jlm_job_details',
        'Job Details',
        'jlm_job_meta_callback',
        'job_listing',
        'normal',
        'default'
    );
}

function jlm_job_meta_callback( $post ) {
    wp_nonce_field( 'jlm_save_job_meta', 'jlm_job_meta_nonce' );

    $company = get_post_meta( $post->ID, 'company_name', true );
    $location = get_post_meta( $post->ID, 'job_location', true );
    $salary = get_post_meta( $post->ID, 'salary_range', true );
    $deadline = get_post_meta( $post->ID, 'application_deadline', true );
    ?>
    <div class="job-meta-box">
        <p>
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($company); ?>" class="widefat">
        </p>
        <p>
            <label for="job_location">Location:</label>
            <input type="text" id="job_location" name="job_location" value="<?php echo esc_attr($location); ?>" class="widefat">
        </p>
        <p>
            <label for="salary_range">Salary Range:</label>
            <input type="number" id="salary_range" name="salary_range" value="<?php echo esc_attr($salary); ?>" class="widefat">
        </p>
        <p>
            <label for="application_deadline">Application Deadline:</label>
            <input type="date" id="application_deadline" name="application_deadline" value="<?php echo esc_attr($deadline); ?>" class="widefat">
        </p>
    </div>
    <?php
}

function jlm_save_job_meta( $post_id, $post ) {
    if ( ! isset( $_POST['jlm_job_meta_nonce'] ) || ! wp_verify_nonce( $_POST['jlm_job_meta_nonce'], 'jlm_save_job_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    if ( $post->post_type !== 'job_listing' ) return;

    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        'company_name' => 'sanitize_text_field',
        'job_location' => 'sanitize_text_field',
        'salary_range' => 'absint',
        'application_deadline' => 'sanitize_text_field'
    );

    foreach ($fields as $field => $sanitize_callback) {
        if (isset($_POST[$field])) {
            $value = call_user_func($sanitize_callback, $_POST[$field]);
            update_post_meta($post_id, $field, $value);
        }
    }
}
