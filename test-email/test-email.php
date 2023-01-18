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
        add_filter('emailcontent_filter', array($this, 'test_modifycontent'), 10, 1);
        add_action('send_email', array($this, 'test_send_email'), 10, 3);
        add_action('phpmailer_init', array($this, 'test_email_config'), 10, 1);
        add_action('plugin_loaded', array($this, 'test_plugin_load_text_domain'));
    }

    /**
     * Function test_plugin_load_text_domain for language traslation
     * 
     */
    public function test_plugin_load_text_domain()
    {
        load_plugin_textdomain('test_email_plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
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
        wp_register_script('form_validation_script', WP_PLUGIN_URL . '/test-email/assets/js/jquery.validate.min.js');
        wp_enqueue_script('send_email_script');
        wp_enqueue_script('form_validation_script');
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

        // ob_start();
        include_once "templates/send_mail.php";
        // return ob_get_clean();
    }

    /**
     * Function for collect data from email form
     * 
     */
    public function test_emaildata()
    {
        global $wpdb;
        global $table_prefix;
        $table = $table_prefix . 'test_email';
        if (isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'email_nonce')) {
            $subject = sanitize_text_field($_POST['subject']);
            $content = sanitize_text_field($_POST['content']);
            $to = sanitize_text_field($_POST['to']);
            if ($subject != null || $content != null || is_email($to) != false) {
                // filter for modify data
                $modified_content = apply_filters('emailcontent_filter', $content);
                $res = $wpdb->insert($table, array(
                    'email' => $to,
                    'subject' => $subject,
                    'content' => $modified_content,
                    'send_date' => date('Y-m-d')
                ), array('%s', '%s', '%s', '%s'));
                if ($res) {
                    do_action("send_email", $subject, $content, $to);
                    _e('<div class="alert alert-success" role="alert">Email is send succefully !! </div>');
                } else {
                    _e('<div class="alert alert-danger" role="alert">Failed to send !! </div>');
                }
            } else {
                _e('<div class="alert alert-danger" role="alert">Please fill the field properly!! </div>');
            }
        } else {
            _e('<div class="alert alert-danger" role="alert">Security Error!! </div>');
        }
        wp_die();
    }

    /**
     * Function to modify email content
     */
    public function test_modifycontent($content)
    {
        $extratext = "This text is modified";
        $content .= $extratext;
        return $content;
    }

    /**
     * Function for config. of phpmailer
     * 
     * @var $phpmailer is phpmailer object
     */
    function test_email_config($phpmailer)
    {
        $phpmailer->isSMTP();
        $phpmailer->SMTPDebug = 2;
        $phpmailer->CharSet  = "utf-8";
        $phpmailer->Host       = 'smtp.gmail.com';
        $phpmailer->Port       = '465';
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Username   = 'chaudharymilan996@gmail.com';
        $phpmailer->Password   = ''; //app password removed for security reasion
        $phpmailer->From    = 'chaudharymilan996@gmail.com';
    }

    /**
     * Function to create register table in database
     * 
     */
    function test_create_table()
    {
        global $wpdb;
        global $table_prefix;
        $table = $table_prefix . 'test_email';
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(100) NOT NULL,
            `subject` varchar(255) NOT NULL,
            `content` varchar(255) NOT NULL,
            `send_date` date NOT NULL,
            PRIMARY KEY (id)
          )";
        $wpdb->query($sql);
        return;
    }

    /**
     * Function to send test email
     * 
     * @var $to email address of user
     */
    public function test_send_email($subject, $content, $to)
    {
        wp_mail($to, $subject, $content);
    }

    /**
     * Function register_active for the plugin activation
     * 
     */
    public function register_active()
    {
        $this->test_emailform();
        $this->test_create_table();
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
