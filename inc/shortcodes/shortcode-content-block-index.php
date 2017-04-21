<?php
/**
 * Implements content-block-index shortcode.
 */

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



function underskeleton_ctb_register_shortcode_content_block_index(){
  add_shortcode('content-block-index', 'underskeleton_ctb_shortcode_content_block_index');
}
add_action( 'init', 'underskeleton_ctb_register_shortcode_content_block_index');



function underskeleton_ctb_shortcode_content_block_index( $atts ){
  extract(shortcode_atts(array(
    'add_container_class' => '',
  ), $atts));

  $return_string = '';

  global $post;
  $pattern_content_blocks = "/\[content-block (.+?)\]/";

  if ( preg_match_all( $pattern_content_blocks, $post->post_content, $matches) && array_key_exists( 1, $matches ) )
  {
    $content_blocks_meta = array();

    // Each shortcode instance
    foreach ( $matches[1] as $key => $shortcode_params_string ) {
      $shortcode_params = array();

      foreach ( explode( ' ', $shortcode_params_string ) as $param_string ) {
        $param_parts = explode( '=', $param_string);

        // remove quotation marks
        $param_key = str_replace( array( "'", '"' ), '', $param_parts[0] );
        $param_value = str_replace( array( "'", '"' ), '', $param_parts[1] );

        $shortcode_params[$param_key] = $param_value;
      }
      
      $content_blocks_meta[$shortcode_params['slug']] = $shortcode_params;
    }



    /*------------------------------------*\
      #RETRIEVE TITLE FROM BLOCKS
    \*------------------------------------*/
    $args = array(
      'suppress_filters' => false,
      'post_name__in' => array_keys( $content_blocks_meta ),
      'post_type' => 'underskeleton_ctb',
    );

    $blocks = get_posts( $args );

    if ( $blocks ) :
      foreach ($blocks as $block ) {
        $content_blocks_meta[ $block->post_name ]['post_title'] = $block->post_title;
      }
    endif;



    /*------------------------------------*\
      #SHORTCODE OUTPUT
    \*------------------------------------*/
    if ( !empty( $content_blocks_meta ) ) :

      // Set container class
      if ( underskeleton_ctb_get_boolean_value( $add_container_class ) ) {
        $container_class = 'container';
      }

      $return_string .= sprintf( '<div class="content-block-index"><ol class="content-block-index__list indexed-list uppercase-items %1$s">',
      $container_class );

      $index = 0;
      foreach ( $content_blocks_meta as $content_block_params ) {
        $index++;

        $element_id = empty( $content_block_params['block_id'] ) ? $content_block_params['slug'] : $content_block_params['block_id'];

        $return_string .= sprintf('<li class="content-block-index__list-item"><span class="indexed-list__index">%3$s</span><a href="%1$s" rel="bookmark">%2$s</a></li>',
          esc_url( '#' . $element_id ),
          esc_html( $content_block_params['post_title'] ),
          sprintf( _x('%02d', 'Format for indexed list item number.' ,'underskeleton_ctb' ), $index )
        );
      }
    
      $return_string .= '</ol></div>';

    endif;
  }

  return $return_string;
}
