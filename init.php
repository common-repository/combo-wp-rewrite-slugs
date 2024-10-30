<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://codezel.com/
 * @since             1.0
 * @package           Combo WP Rewrite Slugs
 *
 * @wordpress-plugin
 * Plugin Name:       Combo WP Rewrite Slugs
 * Plugin URI:        https://codecanyon.net/user/codezel/portfolio
 * Description:       The plugin will allow the admin to rewrite slugs of all registered custom post types, taxonomies and user roles
 * Version:           1.0
 * Author:            CodeZel
 * Author URI:        http://codezel.com/
 * Text Domain:       combo-wp-rewrite-slugs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elevator-activator.php
 */
if( !function_exists( 'activate_rewrite_slugs' ) ) {
	function activate_rewrite_slugs() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-activator.php';
		Rewrite_Slugs_Activator::activate();
	}
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elevator-deactivator.php
 */
if( !function_exists( 'deactivate_rewrite_slugs' ) ) {
	function deactivate_rewrite_slugs() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-deactivator.php';
		Rewrite_Slugs_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_rewrite_slugs' );
register_deactivation_hook( __FILE__, 'deactivate_rewrite_slugs' );

/**
 * Plugin configuration file,
 * It include getter & setter for global settings
 */
require plugin_dir_path( __FILE__ ) . 'config.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-system.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if( !function_exists( 'run_RewriteSlugs' ) ) {
	function run_RewriteSlugs() {
		//last load plugin
		$wp_path_to_this_file   = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
		$this_plugin 			= plugin_basename(trim($wp_path_to_this_file));
		$active_plugins 		= get_option('active_plugins');
		$this_plugin_key 		= array_search($this_plugin, $active_plugins);
		
		if (in_array($this_plugin,$active_plugins) && end($active_plugins) !== $this_plugin ) {
			array_splice($active_plugins, $this_plugin_key, 1);
			array_push($active_plugins, $this_plugin);
			update_option('active_plugins', $active_plugins);
		}

		//load plugin
		$plugin = new Rewrite_Slugs_Core();
		$plugin->run();
	
	}
	run_RewriteSlugs();
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'rewrite_slugs_load_textdomain' );
function rewrite_slugs_load_textdomain() {
  load_plugin_textdomain( 'combo-wp-rewrite-slugs', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
