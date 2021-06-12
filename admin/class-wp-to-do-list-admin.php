<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/admin
 * @author     Mashrur Fahim <imashrurfahim@gmail.com>
 */
class Wp_To_Do_List_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Wp_To_Do_List_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_To_Do_List_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-to-do-list-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_To_Do_List_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_To_Do_List_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-to-do-list-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register WP Todo List widget
	 * 
	 * @since		1.0.0
	 */
	public function wp_to_do_list_register_widget() {
		register_widget( 'Wp_To_Do_List_Widget' );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		// Have options to show it in under plugins menu
		// add_submenu_page( 'plugins.php', 'WP TO DO LIST', 'wp-to-do-list-admin-menu', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page' ) );
		
		// Show it in Settings Menu
		add_options_page( 'WP TO DO LIST', __( 'WP To Do List Widget', 'wp-to-do-list' ), 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ) );



	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

			// $settings_link = array( '<a href="' . admin_url( 'plugins.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>', );

			// -- OR --

			$settings_link = array( '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>', );

			return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

			include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

	/**
	 * Validate fields from admin area plugin settings form ('wp-to-do-list-admin-display.php')
	 * @param  mixed $input as field form settings form
	 * @return mixed as validated fields
	 */
	public function validate($input) {

			$options = get_option( $this->plugin_name );

			$options['enable_widget_text_input'] = ( isset( $input['enable_widget_text_input'] ) && ! empty( $input['enable_widget_text_input'] ) ) ? 1 : 0;

			$options['enable_shortcode_text_input'] = ( isset( $input['enable_shortcode_text_input'] ) && ! empty( $input['enable_shortcode_text_input'] ) ) ? 1 : 0;
			
			return $options;

	}

	public function options_update() {

			register_setting( $this->plugin_name, $this->plugin_name, array(
				'sanitize_callback' => array( $this, 'validate' ),
			) );

	}

}
