<?php
/**
 * Implements content block shortcode.
 *
 * @package underskeleton_ctb
 */

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



class UnderskeletonContentBlockShortcode {
  
  protected static $_instance = null;

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }



  public function __construct() {
    add_action( 'init', array( $this, 'register_shortcode' ), 0 );
  }





  public function register_shortcode() {
    add_shortcode('content-block', array( $this, 'render_shortcode' ) );
  }





  public function render_shortcode( $atts ) {
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

      $block_options = UnderskeletonContentBlocks()->get_block_options( $post->ID );

      $templates = UnderskeletonContentBlocks()->get_templates();
      $block_template = $templates[ 'content-block-simple' ];
      
      if ( isset( $templates[ $block_options['template'] ] ) ) {
        $block_template = $templates[ $block_options['template'] ];
      }
      else {
        $post_title = get_the_title();
        trigger_error("Content Block '{$post_title}': Template '{$block_options['template']}' not registered or removed, using 'simple' instead.", E_USER_NOTICE);
      }

      if ( empty( $block_id ) ) {
        $block_id = $slug;
      }

      if ( !empty( $block_options['custom_css'] ) ) {
        $return_string .= sprintf('<style type="text/css">%s</style>', underskeleton_ctb_sanitize_css( $block_options['custom_css'] ) );
      }

      $block_classes = 'content-block content-block--' . $slug;
      $block_classes .= ' ' . $block_options['custom_classes'];
      $block_classes .= ' ' . $classes;
      $title_classes = 'content-block__title';
      $content_classes = 'content-block__content';

      // Start buffering
      ob_start();
      
      $template = UnderskeletonContentBlocks()->locate_template( $block_template['group'], $block_template['name'] );
      include ( $template );

      // Get buffer contents and release
      $return_string .= ob_get_clean();
      
      // RESET
      wp_reset_postdata();
      
    else :
      trigger_error("Content Block slug '{$slug}' not found, it might have been put in trash or deleted.", E_USER_NOTICE);
    endif;

    return $return_string;
  }
}



function UnderskeletonContentBlockShortcode() {
  return UnderskeletonContentBlockShortcode::instance();
}



// Get instance to initialize class instance
UnderskeletonContentBlockShortcode();
