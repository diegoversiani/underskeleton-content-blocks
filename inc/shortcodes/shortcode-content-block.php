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

    UnderskeletonContentBlocks()->register_template( array(
      'group'              => 'content-block',
      'name'               => 'default',
      'label'              => 'Simple',
     ) );
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

      $block_options = get_post_meta( $post->ID, 'content_block_options', true );
      $block_template = UnderskeletonContentBlocks()->get_templates()[ $block_options['template'] ];

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
      
    endif;

    return $return_string;
  }

}



function UnderskeletonContentBlockShortcode() {
  return UnderskeletonContentBlockShortcode::instance();
}



// Get instance to initialize class instance
UnderskeletonContentBlockShortcode();
