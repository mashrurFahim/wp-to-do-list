<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/public
 * @author     Mashrur Fahim <imashrurfahim@gmail.com>
 */
class Wp_To_Do_List_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-to-do-list-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-to-do-list-public.js', array( 'jquery' ), $this->version, false );
		
		wp_localize_script( $this->plugin_name, 'wpTodoListAjax', array(
					'ajaxURL'	=> admin_url( 'admin-ajax.php' ),
				));

	}

	public function render_form_ajax() {
		if( ! wp_verify_nonce( $_POST['nonce'], 'wp_to_do_list_nonce' ) ) {
        wp_send_json_error();
        wp_die();
    }

		if ( ! check_ajax_referer( 'wp_to_do_list_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Invalid security token sent.' );
        wp_die();
    }

		if ( empty( $_POST['new_task'] ) ) {
        echo __("Task can't be empty", 'wp-to-do-list');
        wp_die();
    }

		$widget_id = sanitize_key( $_POST['widget_id']);
		$user_id = absint($_POST['user_id']);
		$new_task = sanitize_text_field( $_POST['new_task'] );
		$current_time = current_time( 'mysql' );

		global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
    $wp_to_do_list_db_version = get_option( 'wp-to-do-list_db_version', '1.0.0' );
    $data = array(
        'widget_id'     => $widget_id,
        'creator_id'    => $user_id,
        'task_name'     => $new_task,
				'task_status'		=> 0,
        'created_at'    => $current_time,
        
    );
    $format = array( '%s','%d', '%s', '%d', '%s' );

    $wpdb->insert( $table_name, $data, $format );

		$task_id = $wpdb->insert_id;

		$response_data = array(
			'task_id'				=> $task_id,
			'widget_id'     => $widget_id,
			'creator_id'    => $user_id,
			'task_name'     => $new_task,
			'task_status'		=> 0,
			'created_at'    => $current_time,
		);

    // print_r($response_data); 

		wp_die(json_encode($response_data));
	}

	public static function get_all_task() {
		global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
		$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM $table_name") 
							);
		return $results;
	}

	public static function get_all_task_of_widget($wiget_id) {
		global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
		$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM $table_name WHERE widget_id=%s", $wiget_id) 
							);
		return $results;
	}

	public static function get_all_task_of_user($user_id) {
		global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
		$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM $table_name WHERE creator_id=%d", $user_id) 
							);
		return $results;
	}

	public static function get_all_task_of_widget_of_single_user($user_id, $wiget_id) {
		global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
		$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM $table_name WHERE creator_id=%d & widget_id=%s", $user_id, $wiget_id) 
							);
		return $results;
	}

}
