<?php
/**
 * Implements content block shortcode.
 *
 * @package underskeleton_ctb
 */

function underskeleton_ctb_register_shortcode_content_block() {
  add_shortcode('content-block', 'underskeleton_ctb_shortcode_content_block');
}
add_action( 'init', 'underskeleton_ctb_register_shortcode_content_block');



function underskeleton_ctb_shortcode_content_block( $atts ) {
  extract(shortcode_atts(array(
    'slug' => '',
    'block_id' => '',
    'block_style' => '',
    'block_layout' => '',
    'show_title' => '',
    'show_excerpt' => '',
    'add_container_class' => 'y',
  ), $atts));

  $return_string = '';
  $header_style_attr_esc = '';
  $header_classes = '';
  $content_block_style_attr_esc = '';
  $content_block_content_classes = '';
  $block_layout_class = '';
  $container_class = '';
  $block_custom_classes = '';
  $show_image_in_content = false;
  $show_title_in_content = false;
  $show_article_container = false;

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

    $_content_block_custom_classes = get_post_meta($post->ID, '_content_block_custom_classes', true);
    $_content_block_custom_css = get_post_meta($post->ID, '_content_block_custom_css', true);

    $allowed_content_block_styles = array('white', 'green', 'grey');
    $content_block_style_classes = array(
      'white' => 'content-block--white',
      'green' => 'content-block--green',
      'grey' => 'content-block--grey',
      );

    $allowed_content_block_layouts = array('centralized', 'image_left', 'image_right', 'full_background');
    $content_block_layout_classes = array(
      'header_background' => 'content-block--centralized',
      'full_background' => 'content-block--centralized-image',
      'image_left' => 'content-block--lateral-image content-block--image-left',
      'image_right' => 'content-block--lateral-image content-block--image-right',
      'header_left' => 'content-block--header-left',
      );

    if ( !empty( $_content_block_custom_classes ) ) {
      $block_custom_classes = underskeleton_ctb_sanitize_css( $_content_block_custom_classes );
    }

    // Set block style to white if not set or invalid
    if ( empty( $block_style ) || !in_array( $block_style, $allowed_content_block_styles ) ) {
      $block_style_class = '';
    }
    else {
      $block_style_class = $content_block_style_classes[ $block_style ];
    }

    // Set block id as slug if not set
    if ( empty( $block_id ) ) {
      $block_id = $slug;
    }

    // Set container class
    if ( underskeleton_ctb_get_boolean_value( $add_container_class ) ) {
      $container_class = 'container';
    }

    // Set block layout class
    if ( !empty( $block_layout ) ) :

      $block_layout_class = $content_block_layout_classes[ $block_layout ];
      if ( !has_post_thumbnail() && empty( $_content_block_lateral_image_url ) ) {
        $block_layout_class .= ' content-block--no-image';
      }

      // Set variables according to layout
      switch ( $block_layout ) {
        
        case 'centralized':
          $header_classes = 'content-block__header--featured full-background-image';

          if ( has_post_thumbnail() ) {
            $header_style_attr_esc = 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url() ) . ');"';
          }
          break;

        case 'full_background':
          $block_layout_class .= ' full-background-image';

          if ( has_post_thumbnail() ) {
            $content_block_style_attr_esc = 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url() ) . ');"';
          }
          break;

        case 'image_left':
        case 'image_right':

          $show_title_in_content = true;
          $header_classes = 'content-block__header--featured full-background-image';

          if ( has_post_thumbnail() ) {
            $show_image_in_content = true;

            $image_html_for_content_area = '<img class="content-block__image four columns" src="' . esc_url( get_the_post_thumbnail_url() ) . '" aria-hidden="true" role="presentation">';

            // For mobile view
            $header_style_attr_esc = 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url() ) . ');"';
          }

          if ( !empty( $_content_block_lateral_image_url ) ) {

            $show_image_in_content = true;
            $image_html_for_content_area = '<img class="content-block__image four columns" src="' . esc_url( $_content_block_lateral_image_url ) . '" aria-hidden="true" role="presentation">';
          }

          break;
      }
    endif;


    
    /*------------------------------------*\
      #SHORTCODE OUTPUT
    \*------------------------------------*/
    if ( !empty( $_content_block_custom_css ) ) {
      $return_string .= sprintf('<style type="text/css">%1$s</style>', underskeleton_ctb_sanitize_css( $_content_block_custom_css ) );
    }

    $return_string .= sprintf( '<section id="%1$s" class="content-block %2$s %3$s %5$s %6$s" %4$s >',
      esc_attr( $block_id ),
      esc_attr( $block_style_class ),
      esc_attr( $block_layout_class ),
      $content_block_style_attr_esc,
      esc_attr( 'content-block--' . $block_id ),
      esc_attr( $block_custom_classes ) );

    // Encapsule whole article in a container class
    if ( underskeleton_ctb_get_boolean_value( $show_article_container  ) ) {
      $return_string .= sprintf( '<div class="%1$s">', esc_attr( $container_class ) );
    }

    $return_string .= sprintf( '<header class="content-block__header %3$s" %2$s ><div class="%1$s">',
      esc_attr( $container_class ),
      $header_style_attr_esc,
      esc_attr( $header_classes ) );

    // Show title
    if ( underskeleton_ctb_get_boolean_value( $show_title ) ) {
      $return_string .= sprintf('<h2 class="content-block__title">%1$s</h2>', get_the_title() );
    }

    $return_string .= '</div></header>';


    $return_string .= sprintf( '<div class="content-block__content %1$s %2$s" >',
      esc_attr( $container_class ),
      esc_attr( $content_block_content_classes ) );

    // Show image in content area
    if ( underskeleton_ctb_get_boolean_value( $show_image_in_content ) ) {
      $return_string .= $image_html_for_content_area;
      $return_string .= '<div class="content-block__lateral-content eight columns">';
    }

    // Show title in content area
    if ( underskeleton_ctb_get_boolean_value( $show_title_in_content ) ) {
      $return_string .= sprintf('<h2 class="content-block__title">%1$s</h2>', get_the_title() );
    }

    // Show excerpt or full content
    if ( underskeleton_ctb_get_boolean_value( $show_excerpt ) ) {
      $return_string .= apply_filters( 'the_content', get_the_excerpt() );
    }
    else {
      $return_string .= apply_filters( 'the_content', get_the_content() );
    }

    // Show image in content area -- close content column div
    if ( underskeleton_ctb_get_boolean_value( $show_image_in_content ) ) {
      $return_string .= '</div>';
    }

    // Encapsule whole article in a container class -- close content column div
    if ( underskeleton_ctb_get_boolean_value( $show_article_container ) ) {
      $return_string .= '</div>';
    }

    $return_string .= '</div></section>';
    
    // RESET
    wp_reset_postdata();
    
  endif;

  return $return_string;
}
