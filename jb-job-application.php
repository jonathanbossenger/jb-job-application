<?php
/**
 * Plugin Name: JB Job Application
 * Plugin URI: https://github.com/jonathanbossenger/jb-job-application
 * Description: WordPress job application plugin with applicant user role, block-embedded form, and admin dashboard
 * Version: 1.0.0
 * Author: Jonathan Bossenger
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jb-job-application
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('JB_JOB_APP_VERSION', '1.0.0');
define('JB_JOB_APP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('JB_JOB_APP_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Plugin activation hook
 */
function jb_job_app_activate() {
    // Add applicant role
    jb_job_app_add_applicant_role();
    
    // Register custom post type
    jb_job_app_register_post_type();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'jb_job_app_activate');

/**
 * Plugin deactivation hook
 */
function jb_job_app_deactivate() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'jb_job_app_deactivate');

/**
 * Add applicant role
 */
function jb_job_app_add_applicant_role() {
    add_role(
        'applicant',
        __('Applicant', 'jb-job-application'),
        array(
            'read' => true,
            'submit_job_application' => true,
        )
    );
}

/**
 * Register custom post type for job applications
 */
function jb_job_app_register_post_type() {
    $labels = array(
        'name'               => __('Job Applications', 'jb-job-application'),
        'singular_name'      => __('Job Application', 'jb-job-application'),
        'menu_name'          => __('Job Applications', 'jb-job-application'),
        'add_new'            => __('Add New', 'jb-job-application'),
        'add_new_item'       => __('Add New Application', 'jb-job-application'),
        'edit_item'          => __('Edit Application', 'jb-job-application'),
        'view_item'          => __('View Application', 'jb-job-application'),
        'all_items'          => __('All Applications', 'jb-job-application'),
        'search_items'       => __('Search Applications', 'jb-job-application'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'capabilities'        => array(
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-id-alt',
        'supports'            => array('title', 'custom-fields'),
        'show_in_rest'        => false,
    );

    register_post_type('job_application', $args);
}
add_action('init', 'jb_job_app_register_post_type');

/**
 * Add custom meta boxes to job application edit screen
 */
function jb_job_app_add_meta_boxes() {
    add_meta_box(
        'jb_job_app_details',
        __('Application Details', 'jb-job-application'),
        'jb_job_app_render_meta_box',
        'job_application',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'jb_job_app_add_meta_boxes');

/**
 * Render meta box content
 */
function jb_job_app_render_meta_box($post) {
    $first_name = get_post_meta($post->ID, '_jb_first_name', true);
    $last_name = get_post_meta($post->ID, '_jb_last_name', true);
    $email = get_post_meta($post->ID, '_jb_email', true);
    $phone = get_post_meta($post->ID, '_jb_phone', true);
    $resume_url = get_post_meta($post->ID, '_jb_resume_url', true);
    $submitted_date = get_post_meta($post->ID, '_jb_submitted_date', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php esc_html_e('First Name', 'jb-job-application'); ?></label></th>
            <td><?php echo esc_html($first_name); ?></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Last Name', 'jb-job-application'); ?></label></th>
            <td><?php echo esc_html($last_name); ?></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Email', 'jb-job-application'); ?></label></th>
            <td><?php echo esc_html($email); ?></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Phone', 'jb-job-application'); ?></label></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Resume', 'jb-job-application'); ?></label></th>
            <td>
                <?php if ($resume_url): ?>
                    <a href="<?php echo esc_url($resume_url); ?>" target="_blank">
                        <?php esc_html_e('Download Resume', 'jb-job-application'); ?>
                    </a>
                <?php else: ?>
                    <?php esc_html_e('No resume uploaded', 'jb-job-application'); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Submitted', 'jb-job-application'); ?></label></th>
            <td><?php echo esc_html($submitted_date); ?></td>
        </tr>
    </table>
    <?php
}

/**
 * Add custom columns to applications list
 */
function jb_job_app_custom_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Applicant Name', 'jb-job-application');
    $new_columns['email'] = __('Email', 'jb-job-application');
    $new_columns['phone'] = __('Phone', 'jb-job-application');
    $new_columns['resume'] = __('Resume', 'jb-job-application');
    $new_columns['date'] = __('Submitted', 'jb-job-application');
    return $new_columns;
}
add_filter('manage_job_application_posts_columns', 'jb_job_app_custom_columns');

/**
 * Display custom column content
 */
function jb_job_app_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'email':
            echo esc_html(get_post_meta($post_id, '_jb_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_jb_phone', true));
            break;
        case 'resume':
            $resume_url = get_post_meta($post_id, '_jb_resume_url', true);
            if ($resume_url) {
                echo '<a href="' . esc_url($resume_url) . '" target="_blank">' . __('View', 'jb-job-application') . '</a>';
            }
            break;
    }
}
add_action('manage_job_application_posts_custom_column', 'jb_job_app_custom_column_content', 10, 2);

/**
 * Register Gutenberg block
 */
function jb_job_app_register_block() {
    // Register block assets
    wp_register_script(
        'jb-job-app-block',
        JB_JOB_APP_PLUGIN_URL . 'build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components'),
        JB_JOB_APP_VERSION
    );

    wp_register_style(
        'jb-job-app-block-editor',
        JB_JOB_APP_PLUGIN_URL . 'build/editor.css',
        array('wp-edit-blocks'),
        JB_JOB_APP_VERSION
    );

    wp_register_style(
        'jb-job-app-block-frontend',
        JB_JOB_APP_PLUGIN_URL . 'build/style.css',
        array(),
        JB_JOB_APP_VERSION
    );

    // Register block
    register_block_type('jb-job-application/form', array(
        'editor_script' => 'jb-job-app-block',
        'editor_style'  => 'jb-job-app-block-editor',
        'style'         => 'jb-job-app-block-frontend',
        'render_callback' => 'jb_job_app_render_form_block',
    ));
}
add_action('init', 'jb_job_app_register_block');

/**
 * Render the job application form block
 */
function jb_job_app_render_form_block($attributes) {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        return '<div class="jb-job-app-notice">' . 
               __('Please log in to submit a job application.', 'jb-job-application') . 
               ' <a href="' . esc_url(wp_login_url(get_permalink())) . '">' . __('Log in', 'jb-job-application') . '</a>' .
               ' | <a href="' . esc_url(wp_registration_url()) . '">' . __('Register', 'jb-job-application') . '</a>' .
               '</div>';
    }

    // Check if user has applicant role
    $current_user = wp_get_current_user();
    if (!in_array('applicant', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        return '<div class="jb-job-app-notice">' . 
               __('You need to be registered as an applicant to submit job applications.', 'jb-job-application') . 
               '</div>';
    }

    ob_start();
    ?>
    <div class="jb-job-application-form">
        <?php if (isset($_GET['application_submitted']) && $_GET['application_submitted'] == '1'): ?>
            <div class="jb-job-app-success">
                <?php esc_html_e('Your application has been submitted successfully!', 'jb-job-application'); ?>
            </div>
        <?php else: ?>
            <form method="post" enctype="multipart/form-data" id="jb-job-application-form">
                <?php wp_nonce_field('jb_job_app_submit', 'jb_job_app_nonce'); ?>
                
                <div class="form-group">
                    <label for="jb_first_name"><?php esc_html_e('First Name', 'jb-job-application'); ?> <span class="required">*</span></label>
                    <input type="text" id="jb_first_name" name="jb_first_name" required />
                </div>

                <div class="form-group">
                    <label for="jb_last_name"><?php esc_html_e('Last Name', 'jb-job-application'); ?> <span class="required">*</span></label>
                    <input type="text" id="jb_last_name" name="jb_last_name" required />
                </div>

                <div class="form-group">
                    <label for="jb_email"><?php esc_html_e('Email', 'jb-job-application'); ?> <span class="required">*</span></label>
                    <input type="email" id="jb_email" name="jb_email" value="<?php echo esc_attr($current_user->user_email); ?>" required />
                </div>

                <div class="form-group">
                    <label for="jb_phone"><?php esc_html_e('Phone', 'jb-job-application'); ?> <span class="required">*</span></label>
                    <input type="tel" id="jb_phone" name="jb_phone" required />
                </div>

                <div class="form-group">
                    <label for="jb_resume"><?php esc_html_e('Resume (PDF only)', 'jb-job-application'); ?> <span class="required">*</span></label>
                    <input type="file" id="jb_resume" name="jb_resume" accept=".pdf" required />
                    <small><?php esc_html_e('Maximum file size: 5MB', 'jb-job-application'); ?></small>
                </div>

                <div class="form-group">
                    <button type="submit" name="jb_submit_application" class="button button-primary">
                        <?php esc_html_e('Submit Application', 'jb-job-application'); ?>
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Handle form submission
 */
function jb_job_app_handle_submission() {
    if (!isset($_POST['jb_submit_application'])) {
        return;
    }

    // Verify nonce
    if (!isset($_POST['jb_job_app_nonce']) || !wp_verify_nonce($_POST['jb_job_app_nonce'], 'jb_job_app_submit')) {
        wp_die(__('Security check failed', 'jb-job-application'));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_die(__('You must be logged in to submit an application', 'jb-job-application'));
    }

    // Check user role
    $current_user = wp_get_current_user();
    if (!in_array('applicant', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        wp_die(__('You must be an applicant to submit applications', 'jb-job-application'));
    }

    // Validate required fields
    $first_name = sanitize_text_field($_POST['jb_first_name']);
    $last_name = sanitize_text_field($_POST['jb_last_name']);
    $email = sanitize_email($_POST['jb_email']);
    $phone = sanitize_text_field($_POST['jb_phone']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        wp_die(__('All fields are required', 'jb-job-application'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_die(__('Invalid email address', 'jb-job-application'));
    }

    // Handle file upload
    if (!isset($_FILES['jb_resume']) || $_FILES['jb_resume']['error'] !== UPLOAD_ERR_OK) {
        wp_die(__('Resume upload failed', 'jb-job-application'));
    }

    // Validate file type
    $file_type = wp_check_filetype($_FILES['jb_resume']['name']);
    if ($file_type['ext'] !== 'pdf') {
        wp_die(__('Only PDF files are allowed', 'jb-job-application'));
    }

    // Validate file size (5MB max)
    if ($_FILES['jb_resume']['size'] > 5 * 1024 * 1024) {
        wp_die(__('File size must not exceed 5MB', 'jb-job-application'));
    }

    // Upload file
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $upload = wp_handle_upload($_FILES['jb_resume'], array('test_form' => false));

    if (isset($upload['error'])) {
        wp_die($upload['error']);
    }

    // Create job application post
    $post_data = array(
        'post_type'   => 'job_application',
        'post_title'  => $first_name . ' ' . $last_name,
        'post_status' => 'publish',
        'post_author' => $current_user->ID,
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        wp_die(__('Failed to create application', 'jb-job-application'));
    }

    // Save metadata
    update_post_meta($post_id, '_jb_first_name', $first_name);
    update_post_meta($post_id, '_jb_last_name', $last_name);
    update_post_meta($post_id, '_jb_email', $email);
    update_post_meta($post_id, '_jb_phone', $phone);
    update_post_meta($post_id, '_jb_resume_url', $upload['url']);
    update_post_meta($post_id, '_jb_submitted_date', current_time('mysql'));

    // Redirect with success message
    wp_redirect(add_query_arg('application_submitted', '1', wp_get_referer()));
    exit;
}
add_action('template_redirect', 'jb_job_app_handle_submission');

/**
 * Enqueue frontend styles
 */
function jb_job_app_enqueue_styles() {
    wp_enqueue_style(
        'jb-job-app-frontend',
        JB_JOB_APP_PLUGIN_URL . 'assets/css/frontend.css',
        array(),
        JB_JOB_APP_VERSION
    );
}
add_action('wp_enqueue_scripts', 'jb_job_app_enqueue_styles');

/**
 * Enable user registration with applicant role by default
 */
function jb_job_app_set_default_role($user_id) {
    $user = new WP_User($user_id);
    $user->set_role('applicant');
}
add_action('user_register', 'jb_job_app_set_default_role');
