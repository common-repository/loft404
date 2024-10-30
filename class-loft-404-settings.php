<?php
// Not allowed by directly accessing.
if(!defined('ABSPATH')){
	die('Access not allowed!');
}

/**
 * Main class for plugin settings page
 * 
 * @package   Loft404
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 */

if(!class_exists('Loft_404_Settings')){
	class Loft_404_Settings{
		private $page_id; // Plugin setting page id
		private $section_id; // Plugin setting section id
		public function __construct(){
			$this->page_id = 'loft404-settings';
			$this->section_id = 'loft404_settings_section';
			add_action('admin_init', array($this, 'register_setting_fields')); // Register setting fields and settings for saving
			add_action('admin_menu', array($this, 'add_settings_menu')); // Add plugin setting menu
		}
		/**
		 * @description add plugin settings menu
		 */
		public function add_settings_menu(){
			add_options_page(
				esc_html__('Loft404 Settings', 'loft404'), // Page title on html head
				esc_html__('Loft404', 'loft404'), // Menu item label
				'manage_options',
				$this->page_id,
				array($this, 'render_settings_page')
			); // Register the plugin option subpage
		}
		/**
		 * @description render the plugin settings page
		 */
		public function render_settings_page(){
?>
			<div class="wrap">
				<h1><?php esc_html_e('Loft404 Settings', 'loft404'); ?></h1>
				<form method="post" action="<?php echo admin_url('options.php'); ?>">
					<?php do_settings_sections($this->page_id); ?>
					<?php settings_fields($this->section_id); ?>
					<?php $this->get_save_button(); ?>
				</form>
			</div>
<?php
		}
		/**
		 * @description register setting fields and settings for saving
		 */
		public function register_setting_fields(){
			$section_id = $this->section_id;
			add_settings_section($section_id, '', '', $this->page_id); // Register plugin setting section

			add_settings_field('loft404_settings_mode', esc_html__('Enable', 'loft404'), array($this, 'field_mode'), $this->page_id, $section_id);
			add_settings_field('loft404_settings_page_id', esc_html__('Custom 404 page', 'loft404'), array($this, 'field_page'), $this->page_id, $section_id);

			// Register the settings for saving
			register_setting($section_id, 'loft404_mode'); // Register setting mode
			register_setting($section_id, 'loft404_page_id'); // Register setting page id
		}
		/**
		 * @description show the mode setting html 
		 */
		public function field_mode($args){
			$checked = (get_option('loft404_mode', '') === 'on') ? ' checked' : '';
			echo '<label><input' . $checked . ' name="loft404_mode" type="checkbox" value="on"></label>';
		}
		/**
		 * @description html of page setting
		 */
		public function field_page($args){
			wp_dropdown_pages(
				array(
					'name' => 'loft404_page_id',
					'echo' => 1,
					'show_option_none' => '&mdash; ' . esc_html__('Select', 'loft404') . ' &mdash;',
					'option_none_value' => '-1',
					'selected' => get_option('loft404_page_id')
				)
			);
		}
		/**
		 * @description get save button
		 * @return save button html
		*/
		private function get_save_button(){
			echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="' . esc_attr__('Save Changes', 'loft404') . '"></p>';
		}
	}
	new Loft_404_Settings();
}