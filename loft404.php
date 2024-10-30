<?php
/*
Plugin Name: Loft404
Plugin URI: http://www.loftocean.com/
Description: A toolkit to redirect the default 404 page to a custom page.
Version: 1.2.2
Author: Loft Ocean
Author URI: http://www.loftocean.com/
Text Domain: loft404
Domain Path: /languages
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


/**
 * Loft404 main file
 * 
 * @package   Loft404
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 */

// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

if(!class_exists('Loft_404')){
	register_activation_hook(__FILE__, 'loft404_activate'); // 
	register_deactivation_hook(__FILE__, 'loft404_deactivate');
	/*
	 * Update the plugin version for initial version
	 */
	function loft404_activate(){
		update_option('loft404_plugin_version', '1.2.2');
	}
	/**
	 * Do nothing for initial version
	 */
	function loft404_deactivate(){ }
	/**
	 * Define the constant used in this plugin
	 */
	define('LOFT404_ROOT', dirname(__FILE__) . '/');

	/**
	 * Main plugin class
	 * @since version 1.0.0
	 */
	class Loft_404{
		public function __construct(){
			load_plugin_textdomain('loft404', false, dirname(plugin_basename(__FILE__)) . '/languages/'); // Load the text domain
			add_action('init', array($this, 'load_settings')); // Load the plugin settings
			$this->load_front();
		}
		/**
		 * @description load plugin settings page
		 */
		public function load_settings(){
			if(is_admin()){
				require_once LOFT404_ROOT . 'class-loft-404-settings.php';
			}
		}
		/**
		 * @description load functions for front end
		 */
		public function load_front(){
			if(!is_admin()){
				require_once LOFT404_ROOT . 'class-loft-404-front.php';
			}
		}
	}
	new Loft_404(); // Enable Loft_404
}
?>
