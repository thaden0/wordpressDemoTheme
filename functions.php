<?php

define( 'DEMO_THEME_DIR_URI', get_stylesheet_directory_uri() );
define( 'DEMO_THEME_DIR', get_stylesheet_directory() );
function demo_theme_setup() {
    demo_theme_custom_content_type();
    demo_theme_register_nav_menus();
}

function demo_theme_enqueue_styles() {
    wp_enqueue_style( 'demo-theme-style', DEMO_THEME_DIR_URI . '/assets/css/style.css');
}

function demo_theme_register_nav_menus() {
    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
}

function demo_theme_project_fields($post) {
    wp_nonce_field('save_project_fields','project_fields_nonce');

    $name = get_post_meta($post->ID,'project_name',true);
    $description = get_post_meta($post->ID,'project_description',true);
    $start = get_post_meta($post->ID,'start_date',true);
    $end   = get_post_meta($post->ID,'end_date',true);
    $url   = get_post_meta($post->ID,'url',true);

    echo '<div class="form-field"><label class="form-label" for="project-name">'.esc_html__('Name', 'demotheme').'</label><br><input id="project-name" type="text" name="project_name" value="'.esc_attr($name).'" required maxlength="100"></div>';
    echo '<div class="form-field"><label class="form-label" for="project-description">Description</label><br><input id="project-description" type="text" name="project_description" value="'.esc_attr($description).'" required maxlength="255"></div>';
    echo '<div class="form-field"><label class="form-label" for="project-start-date">Start Date</label><br><input id="project-start-date" type="date" name="start_date" value="'.esc_attr($start).'"></div>';
    echo '<div class="form-field"><label class="form-label" for="project-end-date">End Date</label><br><input id="project-end-date" type="date" name="end_date" value="'.esc_attr($end).'"></div>';
    echo '<div class="form-field"><label class="form-label" for="project-url">Project URL</label><br><input id="project-url" type="url" name="url" value="'.esc_attr($url).'"></div>';
      
}

function demo_theme_custom_content_type() {
    register_post_type( 'project',
        [
            'labels' => [
                'name' => 'Projects',
                'singular_name' => 'Project',
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title','editor','thumbnail','custom-fields'],
            'rewrite' => ['slug' => 'project'],
            'show_in_rest' => true,
        ]
    );

    register_post_meta('project', 'start_date', [
        'type' => 'date', 'single' => true, 'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    register_post_meta('project', 'end_date', [
        'type' => 'string', 'single' => true, 'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    register_post_meta('project', 'url', [
        'type' => 'string', 'single' => true, 'show_in_rest' => true,
        'sanitize_callback' => 'esc_url_raw',
    ]);    
}

function demo_theme_add_meta_boxes() {
    add_meta_box('project_fields', 'Project Fields', 'demo_theme_project_fields', 'project', 'normal', 'default');
}

function demo_theme_save_project_fields($post_id) {
    if (!isset($_POST['project_fields_nonce']) || !wp_verify_nonce($_POST['project_fields_nonce'],'save_project_fields')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id) || !current_user_can('edit_projects')) {
        return;
    }

    if (empty($_POST['project_name']) || empty($_POST['project_description'])) {
        return;
    }

    if (!empty($_POST['start_date'])) {
        $start_date = sanitize_text_field($_POST['start_date']);
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)) {
            return; // Invalid date format
        }
        update_post_meta($post_id, 'start_date', $start_date);
    }

    update_post_meta($post_id,'project_name', sanitize_text_field($_POST['project_name'] ?? ''));
    update_post_meta($post_id,'project_description', sanitize_text_field($_POST['project_description'] ?? ''));
    update_post_meta($post_id,'end_date',   sanitize_text_field($_POST['end_date'] ?? ''));

    if (!empty($_POST['url'])) {
        $url = esc_url_raw($_POST['url']);
        if (filter_var($url, FILTER_VALIDATE_URL) && in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'])) {
            update_post_meta($post_id, 'url', $url);
        }
    }
}

add_action( 'wp_enqueue_scripts', 'demo_theme_enqueue_styles' );
add_action( 'init', 'demo_theme_setup' );
add_action('add_meta_boxes', 'demo_theme_add_meta_boxes');
add_action('save_post_project', 'demo_theme_save_project_fields');
add_action('after_setup_theme', 'demo_theme_register_nav_menus');