<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

/**
 * Main class for front end
 * 
 * @package   Loft404
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 * @since version 1.0.0
 */

if(!class_exists('Loft_404_Front')){
	class Loft_404_Front{
		private $mode;
		private $page_id;
		public function __construct(){
			$this->set_variables();
			add_action('template_redirect', array($this, 'page_redirection')); // Page redirection for 404 page
			add_action('wp', array($this, 'send_header')); // Since version 1.2.0
			add_filter('body_class', array($this, 'body_class')); // Since version 1.2.0
		}
		/**
		 * @description set mode status and page id.
		 */
		private function set_variables(){
			$this->mode = get_option('loft404_mode', '');
			$this->page_id = get_option('loft404_page_id', -1);
		}
		/**
		 * @description redirect to custom 404 page
		 *     
		 */
		public function page_redirection(){
			if($this->mode_enabled() && is_404()){
				wp_redirect(get_permalink($this->page_id), 301);
				exit();
			}
		}
		/**
		* @description add body class for custom 404 page
		* @since version 1.2.0
		*/
		public function body_class($class){
			if($this->is_404_page()){
				$class[] = 'error404';
			}
			return $class;
		}
		/**
		* @desription send 404 page header
		* @since version 1.2.0
		*/
		public function send_header(){
			if($this->is_404_page() && !is_customize_preview()){
				status_header(404);
				nocache_headers();
			}
		}
		/*
		 * @description test custom 404 page exists and enabled.
		 * @return boolean
		 */
		private function mode_enabled(){
			return ($this->mode === 'on') && (get_post_status($this->page_id) !== false); 
		}
		/**
		* @description test if current is custom 404 page
		* @return boolean
		*/
		private function is_404_page(){
			return $this->mode_enabled() && is_page($this->page_id);
		}
	}
	new Loft_404_Front();
}