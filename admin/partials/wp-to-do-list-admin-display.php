<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/admin/partials
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>WP Todo List Widget <?php esc_attr_e('Options', 'plugin_name' ); ?></h2>

    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
    <?php
      //Grab all options
      $options = get_option( $this->plugin_name );

      
      $enable_widget_text_input = ( isset( $options['enable_widget_text_input'] ) && ! empty( $options['enable_widget_text_input'] ) ) ? 1 : 0;

      settings_fields($this->plugin_name);
      do_settings_sections($this->plugin_name);

    ?>

    <!-- Checkbox -->
    <fieldset>
      <p><?php esc_attr_e( 'This settings is used for displaying new task field in widget area.', 'wp-to-do-list' ); ?></p>
      <legend class="enable-widget-input">
        <span><?php esc_attr_e( 'Note: By Enableing it, New task input field widget settings enable globally .', 'wp-to-do-list' ); ?></span>
      </legend>
      <label for="<?php echo $this->plugin_name; ?>-enable-widget-input">
        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-enable-widget-input" name="<?php echo $this->plugin_name; ?>[enable_widget_text_input]" value="1" <?php checked( $enable_widget_text_input, 1 ); ?> />
        <span><?php esc_attr_e('Enable Widget Input Field', 'wp-to-do-list' ); ?></span>
      </label>
    </fieldset>

    <?php submit_button( __( 'Save all changes', 'wp-to-do-list' ), 'primary','submit', TRUE ); ?>
    </form>
</div>