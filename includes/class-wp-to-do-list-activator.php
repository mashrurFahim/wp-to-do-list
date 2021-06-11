<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/includes
 * @author     Mashrur Fahim <imashrurfahim@gmail.com>
 */
class Wp_To_Do_List_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::create_db();
	}


	public static function create_db() {

    global $wpdb;
    $table_name = $wpdb->prefix . "wp_to_do_list";
    $wp_to_do_list_db_version = get_option( 'wp-to-do-list_db_version', '1.0.0' );

		if( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ||
        version_compare( $wp_to_do_list_db_version, '1.0.0' ) < 0 ) {
			
					$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				task_id integer NOT NULL AUTO_INCREMENT,
				widget_id varchar(256) NOT NULL,
				creator_id integer NOT NULL,
				task_name text DEFAULT '' NOT NULL,
				task_status varchar(10) DEFAULT 'incomplete' NOT NULL,
				created_at DATETIME DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (task_id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


			dbDelta( $sql );

			add_option( 'wp-to-do-list_db_version', $wp_to_do_list_db_version );
		}

	}

}
