<?php
/**
 * Implements content block shortcode.
 *
 * @package underskeleton_ctb
 */

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



function underskeleton_ctb_register_shortcode_content_block() {
  add_shortcode('content-block', 'underskeleton_ctb_shortcode_content_block');
}
add_action( 'init', 'underskeleton_ctb_register_shortcode_content_block');



function underskeleton_ctb_shortcode_content_block( $atts ) {
  extract(shortcode_atts(array(
    'slug' => '',
    'classes' => '',
    'block_id' => '',
    'show_title' => 'no',
    'show_excerpt' => 'no',
  ), $atts));

  $return_string = '';

  // SLUG REQUIRED, exit if empty
  if ( empty( $slug ) ) {
    return '';
  }

  $args = array(
    'suppress_filters' => false,
    'name' => $slug,
    'post_type' => 'underskeleton_ctb',
  );

  $posts = get_posts( $args );

  if ( $posts ) :
    
    global $post;
    $post = $posts[0];
    setup_postdata( $post );
    
    $block_custom_classes = get_post_meta($post->ID, '_content_block_custom_classes', true);
    $block_custom_css = get_post_meta($post->ID, '_content_block_custom_css', true);

    if ( empty( $block_id ) ) {
      $block_id = $slug;
    }

    if ( !empty( $block_custom_css ) ) {
      $return_string .= sprintf('<style type="text/css">%1$s</style>', underskeleton_ctb_sanitize_css( $block_custom_css ) );
    }

    $block_classes = 'content-block content-block--' . $slug;
    $block_classes .= ' ' . $block_custom_classes;
    $block_classes .= ' ' . $classes;
    $title_classes = 'content-block__title';
    $content_classes = 'content-block__content';

    // Start buffering
    ob_start();
    
    $template = locate_template( UNDERSKELETON_CONTENT_BLOCKS_THEME_TEMPLATES_FOLDER . 'content-block.php' );
    if ( empty($template) ) $template = UNDERSKELETON_CONTENT_BLOCKS_TEMPLATES_FOLDER . 'content-block.php';
    include ( $template );

    // Get buffer contents and release
    $return_string .= ob_get_clean();
    
    // RESET
    wp_reset_postdata();
    
  endif;

  return $return_string;
}
