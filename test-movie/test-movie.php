<?php

/**
 * Plugin Name:       test-movie
 * Plugin URI:        https:milankumarchaudhary.com.np
 * Description:       movie details
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Milan Kumar Chaudhary
 * Author URI:        https:milankumarchaudhary.com.np
 */
defined('ABSPATH') or die('error!! You cant access');
class Test_movie
{
    /**
     * Class contructor
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'custom_meta_boxs'));
        add_action('add_meta_boxes', array($this, 'movie_custom_meta_boxs'));
        add_action('save_post', array($this, 'save_custom_text_box'));
        add_action('save_post', array($this, 'save_custom_select_box'));
        add_action('save_post', array($this, 'save_custom_textarea_box'));
        add_action('save_post', array($this, 'save_movie_director'));
        add_action('save_post', array($this, 'save_movie_casts'));
        add_action('save_post', array($this, 'save_movie_release_date'));

        add_action('init', array($this, 'movie_custom_post_type'));
        add_action('init', array($this, 'fruits_custom_taxonomy'));
    }

    /**
     * Function for fruits custom taxonomy
     */
    public function fruits_custom_taxonomy()
    {
        $labels = array(
            'name'=>'Fruits',
            'singular_name' => 'fruit',
            'search_items' => "search fruit"
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug'=>'fruits'],
        );
        register_taxonomy('fruits', ['post'], $args);
    }
    /**
     * Function add movie costum meta box
     * 
     */
    public function movie_custom_meta_boxs()
    {
        add_meta_box(
            'movie_director_box',
            'movie director',
            array($this, 'movie_director_html'),
            'movie',
            'side'
        );
        add_meta_box(
            'movie_casts_box',
            'movie casts',
            array($this, 'movie_casts_html'),
            'movie',
            'side'
        );
        add_meta_box(
            'movie_release_date_box',
            'movie release date',
            array($this, 'movie_release_date_html'),
            'movie',
            'side'
        );

    }
    public function movie_director_html($post)
    {
        $value = get_post_meta($post->ID, '_movie_director', true);
        ?>
        <input type="text" name="movie_director" id="movie_director" value="<?php esc_attr($value); ?>" />
        <?php
    }
    public function movie_casts_html($post)
    {
        $value = get_post_meta($post->ID, '_movie_casts', true);

        ?>
        <input type="text" name="movie_casts" id="movie_casts" value="<?php esc_attr($value)?>" />
        <?php
    }
    public function movie_release_date_html($post)
    {
        $value = get_post_meta($post->ID, '_movie_release_date', true);

        ?>
        <input type="text" name="movie_release_date" id="movie_release_date" value="<?php esc_attr($value) ?>" />
        <?php
    }
    public function save_movie_director($post_id)
    {
        if (array_key_exists('movie_director', $_POST)) {
            $input_value = sanitize_text_field($_POST['movie_director']);
            update_post_meta(
                $post_id,
                '_movie_director',
                $input_value
            );
        }
    }
    public function save_movie_casts($post_id)
    {
        
        if (array_key_exists('movie_casts', $_POST)) {
            $input_value = sanitize_text_field($_POST['movie_casts']);
            update_post_meta(
                $post_id,
                '_movie_casts',
                $input_value
            );
        }
    }
    public function save_movie_release_date($post_id)
    {
        
        if (array_key_exists('movie_release_date', $_POST)) {
            $input_value = sanitize_text_field($_POST['movie_release_date']);
            update_post_meta(
                $post_id,
                '_movie_release_date',
                $input_value
            );
        }
    }
    /**
     * Function to add costum post product detail form
     * 
     */
    public function custom_meta_boxs()
    {
        $screen = ['post'];
        add_meta_box(
            'custom_text_box',
            'custom text box',
            array($this, 'custom_text_box_html'),
            $screen,
            'side'

        );
        add_meta_box(
            'custom_select_box',
            'custom select box',
            array($this, 'custom_select_box_html'),
            $screen,
            'side'
        );
        add_meta_box(
            'custom_textarea_box',
            'custom textarea box',
            array($this, 'custom_textarea_html'),
            $screen,
            'side'
        );
    }
    /**
     * Function for select box html
     * 
     */
    public function custom_select_box_html($post)
    {
        $value = get_post_meta($post->ID, '_custom_select_box', true);
?>

        <select name="input_select">
            <option value="Yes" <?php selected($value, 'Yes'); ?>>Yes</option>
            <option value="No" <?php selected($value, 'No') ?>>No</option>
        </select>
    <?php
    }
    
    /**
     * Function for textarea html
     * 
     */
    public function custom_textarea_html($post)
    {
        $value = get_post_meta($post->ID, '_custom_textarea_box', true);
    ?>

        <textarea name="input_textarea"><?php esc_textarea($value) ?></textarea>
    <?php
    }

    /**
     * Function of custom text box html
     * 
     */
    public function custom_text_box_html($post)
    {
        $value = get_post_meta($post->ID, '_custom_text_box', true);
    ?>
        <input type="text" name="input_text" id="text_input" value="<?php esc_attr($value) ?>" />
<?php
    }

    /**
     * Function to save custom textarea box data
     * 
     */
    public function save_custom_textarea_box($post_id)
    {
        if (array_key_exists('input_textarea', $_POST)) {
            $input_value = sanitize_text_field($_POST['input_textarea']);
            update_post_meta(
                $post_id,
                '_custom_textarea_box',
                $input_value
            );
        }
    }

     /**
     * Function to save custom select box data
     * 
     */
    public function save_custom_select_box($post_id)
    {
        if (array_key_exists('input_select', $_POST)) {
            $input_value = sanitize_text_field($_POST['input_select']);
            update_post_meta(
                $post_id,
                '_custom_select_box',
                $input_value
            );
        }
    }

     /**
     * Function to save custom text box data
     * 
     */
    public function save_custom_text_box($post_id)
    {
        if (array_key_exists('input_text', $_POST)) {
            $input_value = sanitize_text_field($_POST['input_text']);
            update_post_meta(
                $post_id,
                '_custom_text_box',
                $input_value
            );
        }
    }

    /**
     * Function custom post type
     * 
     */
    public function movie_custom_post_type()
    {
        $labels = array(
            'name'=>'Movies',
            'singular_name'=>'Movie',
            'add_new'=>'Add Movie',
            'add_new_item'=>"Movie Title",

        );
        $supports = array(
            'title', 'editor', 'thumbnail', 'comments', 'excerpts'
        );
        register_post_type('movie', array(
            'labels'=>$labels,
            'description'=>"we can add movies",
            'public'=> true,
            'has_archive' => true,
            'rewrite' => array('slug'=>'movies'),
            'publicly_queryable'=>true,
            'show_ui'=>true,
            'supports'=>$supports,
        ));
    }
    /**
     * Funciton to active plugin
     * 
     */
    public function test_register_activate()
    {
        flush_rewrite_rules();
    }

    /**
     * Function to deactive the plugins
     */
    public function test_register_deactivate()
    {
        flush_rewrite_rules();
    }
}
// If class is exit the create object of class
if (class_exists('Test_movie')) {
    $movie = new Test_movie();
}

//activation and deactivation hook for plugin
register_activation_hook(__FILE__, array($movie, 'test_register_activate'));
register_deactivation_hook(__FILE__, array($movie, 'test_register_deactivate'));
