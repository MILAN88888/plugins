<?php

/**
 * Plugin Name:       test-email
 * Plugin URI:        https://github.com/MILAN88888/plugins/tree/main/test-email
 * Description:       It is used to send email using ajax.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Milan Chaudhary
 * Author URI:        https:milankumarchaudhary.com.np
 */
if (!defined('ABSPATH')) {
    die('You can not access it directly');
}

class test_email
{
    /**
     * Constructor of class
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'test_emailmenu'));
        add_action('admin_enqueue_scripts', array($this, 'test_emailenqueuer'));

        add_action('wp_ajax_emaildata', array($this, 'test_emaildata'));
        add_filter('emailcontent_filter',array($this, 'test_modifycontent'),10,1);
    }

    /**
     * Function to load script and style
     * 
     */
    public function test_emailenqueuer()
    {
        wp_register_style('style', WP_PLUGIN_URL . '/test-email/assets/bootstrap/css/bootstrap.min.css', false, 'all   ');
        wp_enqueue_style('style');
        wp_register_script('send_email_script', WP_PLUGIN_URL . '/test-email/assets/js/test_email.js', array('jquery'), '1.0.0', true);
        wp_localize_script('send_email_script', 'myscript', array('ajaxurl' => admin_url('admin-ajax.php'), 'my_script_nonce' => wp_create_nonce('email_nonce')));
        wp_enqueue_script('send_email_script');
    }
    /**
     * Function test_email_menu it used to create menus
     * 
     */
    public function test_emailmenu()
    {
        add_menu_page("Test Email", "Test Email", "manage_options", "test-email-slug", array($this, 'test_emailform'), plugins_url('assets/img/icon.png', __FILE__));
        add_submenu_page("test-email-slug", "Send Email", "Send Email", "manage_options", "send-email-slug", array($this, 'test_emailform'));
    }

    /**
     * Function test email
     * 
     */
    public function test_emailform()
    {

        include_once "templates/send_mail.php";
    }

    /**
     * Function for collect data from email form
     * 
     */
    public function my_emaildata()
    {
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'email_nonce')) {
            return;
        }

        $subject = sanitize_text_field($_POST['subject']);
        $content = sanitize_text_field($_POST['content']);
        $modified_content = apply_filters('emailcontent_filter', $content);
        $to = sanitize_text_field($_POST['to']);

        $data = array(
            
        );

        wp_die();
    }

    /**
     * Function to modify email content
     */
    public function test_modifycontent($content)
    {
        $extratext = "This text is modified";
        $content .=$extratext;
        return $content;
    }

    /**
     * Function register_active for the plugin activation
     * 
     */
    public function register_active()
    {
        $this->test_emailform();
        flush_rewrite_rules();
    }

    /**
     * Function register_deactive for the plugin deactivation
     * 
     */
    public function register_deactive()
    {
        flush_rewrite_rules();
    }
}

// checking class exit or not and create object of class.
if (class_exists('test_email')) {
    $testemail = new test_email();
}

//register activation and deactivation hook
register_activation_hook(__FILE__, array($testemail, 'register_active'));
register_deactivation_hook(__FILE__, array($testemail, 'register_deactive'));
