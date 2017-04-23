<?php
/**
 * Register content block post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



function underskeleton_ctb_custom_post_type_content_block() {
  $labels = array(
    'name'               => _x( 'Content Blocks', 'post type general name', 'underskeleton_ctb' ),
    'singular_name'      => _x( 'Content Block', 'post type singular name', 'underskeleton_ctb' ),
    'menu_name'          => _x( 'Content Blocks', 'admin menu', 'underskeleton_ctb' ),
    'name_admin_bar'     => _x( 'Content Block', 'add new on admin bar', 'underskeleton_ctb' ),
    'add_new'            => _x( 'Add New', 'content block', 'underskeleton_ctb' ),
    'add_new_item'       => __( 'Add New Content Block', 'underskeleton_ctb' ),
    'new_item'           => __( 'New Content Block', 'underskeleton_ctb' ),
    'edit_item'          => __( 'Edit Content Block', 'underskeleton_ctb' ),
    'view_item'          => __( 'View Content Block', 'underskeleton_ctb' ),
    'all_items'          => __( 'All Content Blocks', 'underskeleton_ctb' ),
    'search_items'       => __( 'Search Content Blocks', 'underskeleton_ctb' ),
    'parent_item_colon'  => __( 'Parent Content Blocks:', 'underskeleton_ctb' ),
    'not_found'          => __( 'No content blocks found.', 'underskeleton_ctb' ),
    'not_found_in_trash' => __( 'No content blocks found in Trash.', 'underskeleton_ctb' )
  );

  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Show information in a content block format.', 'underskeleton_ctb' ),
    'public'             => false,
    'publicly_queryable' => false,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'content-block' ),
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'excerpt', 'revisions' )
  );

  register_post_type( 'underskeleton_ctb', $args );
}
add_action( 'init', 'underskeleton_ctb_custom_post_type_content_block', 0 );



function underskeleton_ctb_add_content_block_metaboxes() {
  add_meta_box('underskeleton_ctb_options', __('Content Block Options', 'underskeleton_ctb'), 'underskeleton_ctb_options_metabox_render', 'underskeleton_ctb', 'normal', 'high');
}
add_action( 'add_meta_boxes_underskeleton_ctb', 'underskeleton_ctb_add_content_block_metaboxes' );



function underskeleton_ctb_options_metabox_render() {
  global $post;

  $_content_block_custom_classes= get_post_meta($post->ID, '_content_block_custom_classes', true);
  $_content_block_custom_css = get_post_meta($post->ID, '_content_block_custom_css', true);

  // create nonce
  wp_nonce_field( basename( __FILE__ ), 'underskeleton_ctb_options_nonce');
  ?>
    <p>
      <label for="_content_block_custom_classes"><?php _e( 'Custom Classes:', 'underskeleton_ctb' ); ?></label><br>
      <input name="_content_block_custom_classes" id="_content_block_custom_classes" type="text" value="<?php echo esc_attr( $_content_block_custom_classes ); ?>" class="metabox-field-wide">
    </p>

    <p>
      <label for="_content_block_custom_css"><?php _e( 'Custom CSS:', 'underskeleton_ctb' ); ?></label><br>
      <textarea name="_content_block_custom_css" id="_content_block_custom_css" type="text" class="metabox-field-wide" rows="8"><?php echo underskeleton_ctb_sanitize_css( $_content_block_custom_css ); ?></textarea>
    </p>

  <?php
}



/**
 * Save metaboxes content.
 */
function underskeleton_ctb_content_block_metaboxes_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
    return;
  }

  // CONTENT BLOCK FIELDS
  if ( isset( $_POST['underskeleton_ctb_options_nonce'] ) && wp_verify_nonce( $_POST['underskeleton_ctb_options_nonce'], basename( __FILE__ ) ) ) {

    // CUSTOM CLASSES
    if ( isset( $_POST['_content_block_custom_classes'] ) ) {
      update_post_meta( $post_id, '_content_block_custom_classes', sanitize_text_field( $_POST['_content_block_custom_classes'] ) );
    }

    // CUSTOM CSS
    if ( isset( $_POST['_content_block_custom_css'] ) ) {
      update_post_meta( $post_id, '_content_block_custom_css', underskeleton_ctb_sanitize_css( $_POST['_content_block_custom_css'] ) );
    }

  }

}
add_action( 'save_post_underskeleton_ctb', 'underskeleton_ctb_content_block_metaboxes_save' );
