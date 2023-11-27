<?php
/*
Plugin Name: Snoka Extra Menu Attributes
Description: Adds the ability to add data-target attributes and custom classes to menu items.
Version: 1.0
Author: Snoka Media
Author URI: https://snoka.ca
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add setup function.
function snoka_data_target_menu_items_setup() {
    add_action( 'admin_head-nav-menus.php', 'snoka_data_target_menu_items_screen_options' );
}

add_action( 'admin_init', 'snoka_data_target_menu_items_setup' );

// Add screen options.
function snoka_data_target_menu_items_screen_options() {
    add_filter( 'manage_nav-menus_columns', 'snoka_data_target_menu_items_screen_options_columns', 99 );
}

function snoka_data_target_menu_items_screen_options_columns( $columns ) {
    $columns['data-target'] = __( 'Data Target', 'snoka_menu_attributes' );
    $columns['custom-class'] = __( 'Custom Class', 'snoka_menu_attributes' );
    return $columns;
}

// Add our custom fields to menu item.
function add_data_target_field_to_menu_item( $item_id, $item, $depth, $args ) {
    // Check if user has chosen to display this field.
    $user_options = get_user_option( 'managenav-menuscolumnshidden' );
    $display_data_target = ! in_array( 'data-target', $user_options );
    $display_custom_class = ! in_array( 'custom-class', $user_options );

    // If the user has chosen to hide the fields, don't display them.
    if ( ! $display_data_target && ! $display_custom_class ) return;

    // Get the values.
    $data_target = get_post_meta( $item_id, '_menu_item_data_target', true );
    $custom_class = get_post_meta( $item_id, '_menu_item_custom_class', true );
    ?>

    <!-- Data Target Field -->
    <?php if ( $display_data_target ): ?>
    <p class="field-data-target description description-wide">
        <label for="edit-menu-item-data-target-<?php echo esc_attr( $item_id ); ?>">
            <?php _e( 'Data Target', 'snoka_menu_attributes' ); ?><br />
            <input type="text" id="edit-menu-item-data-target-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-data-target[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $data_target ); ?>" />
        </label>
    </p>
    <?php endif; ?>

    <!-- Custom Class Field -->
    <?php if ( $display_custom_class ): ?>
    <p class="field-custom-class description description-wide">
        <label for="edit-menu-item-custom-class-<?php echo esc_attr( $item_id ); ?>">
            <?php _e( 'Custom Class', 'snoka_menu_attributes' ); ?><br />
            <input type="text" id="edit-menu-item-custom-class-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-custom-class[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $custom_class ); ?>" />
        </label>
    </p>
    <?php endif; ?>

    <?php
}

add_action( 'wp_nav_menu_item_custom_fields', 'add_data_target_field_to_menu_item', 10, 4 );

// Save custom field values.
function save_menu_item_custom_fields( $menu_id, $menu_item_db_id, $args ) {
    if ( isset( $_REQUEST['menu-item-data-target'][ $menu_item_db_id ] ) ) {
        update_post_meta( $menu_item_db_id, '_menu_item_data_target', sanitize_text_field( $_REQUEST['menu-item-data-target'][ $menu_item_db_id ] ) );
    }
    // Save custom class if it's set.
    if ( isset( $_REQUEST['menu-item-custom-class'][ $menu_item_db_id ] ) ) {
        update_post_meta( $menu_item_db_id, '_menu_item_custom_class', sanitize_text_field( $_REQUEST['menu-item-custom-class'][ $menu_item_db_id ] ) );
    }
}

add_action( 'wp_update_nav_menu_item', 'save_menu_item_custom_fields', 10, 3 );

// Inject attributes into menu item.
function add_custom_attributes_to_menu_link( $atts, $item, $args, $depth ) {
    $data_target = get_post_meta( $item->ID, '_menu_item_data_target', true );
    $custom_class = get_post_meta( $item->ID, '_menu_item_custom_class', true ); // Retrieve custom class.

    if ( ! empty( $data_target ) ) {
        $atts['data-target'] = $data_target;
    }
    if ( ! empty( $custom_class ) ) {
        $atts['class'] = $custom_class; // Add custom class to link attributes.
    }
    return $atts;
}

add_filter( 'nav_menu_link_attributes', 'add_custom_attributes_to_menu_link', 10, 4 );
