<?php

/**
 * Enqueue scripts and styles.
 */
function underskeleton_ctb_register_scripts_and_styles() {
  
  // Scripts
  wp_register_script( 'underskeleton_ctb-admin-scripts', UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_URL . '/js/admin.min.js', array(), '1.0.0', true );

  // Styles
  wp_register_style( 'underskeleton_ctb-admin-style',
    UNDERSKELETON_CONTENT_BLOCKS_PLUGIN_URL . '/css/admin.min.css' );

}
add_action( 'wp_enqueue_scripts', 'underskeleton_ctb_register_scripts_and_styles' );
