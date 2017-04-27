<?php

/**
 * Enqueue scripts and styles.
 */
function underskeleton_ctb_admin_scripts( $hook_suffix ) {
  if( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
    $screen = get_current_screen();

    if( is_object( $screen ) && $screen->post_type == 'underskeleton_ctb' ){
      // Scripts
      wp_enqueue_script( 'underskeleton_ctb-admin-scripts', UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_URL . '/js/admin.min.js', array(), '1.0.0', true );

      // Styles
      wp_enqueue_style( 'underskeleton_ctb-admin-style',
        UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_URL . '/css/admin.min.css' );
    }
  }
}
add_action( 'admin_enqueue_scripts', 'underskeleton_ctb_admin_scripts' );
