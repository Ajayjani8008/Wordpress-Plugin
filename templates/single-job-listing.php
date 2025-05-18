<?php
/**
 * Template for displaying single job listings
 */

get_header(); ?>

<div class="job-single-container">
    <article id="post-<?php the_ID(); ?>" <?php post_class('job-single'); ?>>
        <header class="entry-header">
            <?php if (has_post_thumbnail()): ?>
                <div class="job-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            
            <h1 class="entry-title"><?php the_title(); ?></h1>
            
            <div class="job-meta-data">
                <?php
                $company_name = get_post_meta(get_the_ID(), 'company_name', true);
                $location = get_post_meta(get_the_ID(), 'job_location', true);
                $salary = get_post_meta(get_the_ID(), 'salary_range', true);
                $deadline = get_post_meta(get_the_ID(), 'application_deadline', true);
                ?>
                
                <?php if ($company_name): ?>
                    <div class="job-company">
                        <strong><?php _e('Company:', 'job-listing-manager'); ?></strong>
                        <?php echo esc_html($company_name); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($location): ?>
                    <div class="job-location">
                        <strong><?php _e('Location:', 'job-listing-manager'); ?></strong>
                        <?php echo esc_html($location); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($salary): ?>
                    <div class="job-salary">
                        <strong><?php _e('Salary Range:', 'job-listing-manager'); ?></strong>
                        <?php echo esc_html($salary); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($deadline): ?>
                    <div class="job-deadline">
                        <strong><?php _e('Application Deadline:', 'job-listing-manager'); ?></strong>
                        <?php echo esc_html($deadline); ?>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <div class="entry-content">
            <div class="job-description">
                <h2><?php _e('Job Description', 'job-listing-manager'); ?></h2>
                <?php the_content(); ?>
            </div>
        </div>
    </article>
</div>

<style>
    .job-single-container {
        max-width: 1200px;
        margin: 2em auto;
        padding: 0 20px;
    }
    .job-single {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .job-featured-image {
        margin-bottom: 20px;
    }
    .job-featured-image img {
        width: 100%;
        height: auto;
        border-radius: 6px;
    }
    .entry-title {
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #333;
    }
    .job-meta-data {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 30px;
    }
    .job-meta-data > div {
        margin: 10px 0;
        font-size: 1.1em;
    }
    .job-meta-data strong {
        display: inline-block;
        min-width: 150px;
        color: #555;
    }
    .job-description {
        line-height: 1.6;
    }
    .job-description h2 {
        color: #333;
        margin-bottom: 20px;
    }
</style>

<?php get_footer(); ?>
