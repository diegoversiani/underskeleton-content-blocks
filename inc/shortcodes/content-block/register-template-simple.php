<?php

function underskeleton_ctb_register_content_block_template_simple() {
  UnderskeletonContentBlocks()->register_template( array(
      'group'              => 'content-block',
      'name'               => 'simple',
      'label'              => __('Simple', 'underskeleton_ctb' ),
    ) );

  add_action( 'underskeleton_ctb_options_metabox', 'underskeleton_ctb_template_simple_options_metabox' );
  
  add_filter( 'underskeleton_ctb_before_save_block_options', 'underskeleton_ctb_template_simple_before_save' );
}
add_action( 'init', 'underskeleton_ctb_register_content_block_template_simple' );



function underskeleton_ctb_template_simple_options_metabox( $block_options ) {
  global $post;
  $content = $post->post_content;

  // create nonce
  wp_nonce_field( basename( __FILE__ ), 'underskeleton_ctb_template_simple_options_nonce' );
  ?>

  <div class="content-block-template-options content-block-simple-options">
    <p>
      <?php wp_editor( $content, 'content' ); ?>
    </p>
  </div>

  <?php
}





function underskeleton_ctb_template_simple_before_save( $block_options ) {

  if ( wp_verify_nonce( $_POST['underskeleton_ctb_template_simple_options_nonce'], basename( __FILE__ ) )
    && $block_options['template'] == 'content-block-simple' ) {
    global $post;
    $post->post_content = wp_kses_post( $_POST['content'] );
  }

  return $block_options;
}
