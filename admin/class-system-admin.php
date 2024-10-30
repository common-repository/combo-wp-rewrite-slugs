<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codezel.com/
 * @since      1.0.0
 *
 * @package    RewriteSlugs
 * @subpackage RewriteSlugs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    RewriteSlugs
 * @subpackage RewriteSlugs/admin
 * @author     CodeZel <thecodezel@gmail.com>
 */
class Rewrite_Slugs_Admin {
	
    public function __construct() {
        $this->plugin_name = RewriteSlugsGlobalSettings::get_plugin_name();
        $this->version = RewriteSlugsGlobalSettings::get_plugin_verion();
        $this->plugin_path = RewriteSlugsGlobalSettings::get_plugin_path();
        $this->plugin_url = RewriteSlugsGlobalSettings::get_plugin_url();
		$this->prepare_post_types();
    }
	
	/**
     * Register the spost types for the admin area.
     *
     * @since    1.0.0
     */
    public function prepare_post_types() {
		$dir	= $this->plugin_path;
		$scan_PostTypes = glob("$dir/admin/post-types/*");
		foreach ($scan_PostTypes as $filename) {
			@include $filename;
		}
	}

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rewrite_Slugs_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rewrite_Slugs_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('rewrite-styles', $this->plugin_url . 'admin/css/rewrite-admin.css', array(), $this->version, 'all');
    
        
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rewrite_Slugs_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rewrite_Slugs_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script('rewrite-functions', $this->plugin_url . 'admin/js/rewrite-functions.js', array('jquery'), $this->version, false);
		
		$dir_spinner = RewriteSlugsGlobalSettings::get_plugin_url() . '/admin/images/spinner.gif';
		
		wp_localize_script('rewrite-functions', 'localize_vars', array(
			'spinner' => '<img class="sp-spin" src="'.esc_url($dir_spinner).'">'
		 ));
    }
}
