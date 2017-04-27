<?php


function underskeleton_ctb_register_content_block_custom_template() {
  UnderskeletonContentBlocks()->register_template( array(
      'group'              => 'content-block',
      'name'               => 'custom',
      'label'              => 'Custom Template',
    ) );

  add_action( 'underskeleton_ctb_options_metabox', 'underskeleton_ctb_custom_template_options_metabox' );
  add_filter( 'underskeleton_ctb_before_save_block_options', 'underskeleton_ctb_custom_template_before_save' );
}
add_action( 'init', 'underskeleton_ctb_register_content_block_custom_template' );





function underskeleton_ctb_custom_template_options_metabox( $block_options ) {
  
  $color_1 = isset( $block_options['color_1'] ) ? $block_options['color_1'] : '';
  $color_2 = isset( $block_options['color_2'] ) ? $block_options['color_2'] : '';

  ?>

  <div class="content-block-template-options content-block-custom-options">
    <p>
      <label for="content_block_options[color_1]"><?php _e( 'Color 1:', 'underskeleton_ctb' ); ?></label><br>
      <input name="content_block_options[color_1]" id="content_block_options[color_1]" type="text" value="<?php echo esc_attr( $color_1 ); ?>" class="widefat">
    </p>

    <p>
      <label for="content_block_options[color_2]"><?php _e( 'Color 2:', 'underskeleton_ctb' ); ?></label><br>
      <input name="content_block_options[color_2]" id="content_block_options[color_2]" type="text" value="<?php echo esc_attr( $color_2 ); ?>" class="widefat">
    </p>
  </div>

  <?php
}





function underskeleton_ctb_custom_template_before_save( $block_options ) {

  if ( $block_options['template'] == 'content-block-custom' ) {
    $block_options['color_1'] = sanitize_hex_color( $_POST['content_block_options']['color_1'] );
    $block_options['color_2'] = sanitize_hex_color( $_POST['content_block_options']['color_2'] );
  }

  return $block_options;
}
