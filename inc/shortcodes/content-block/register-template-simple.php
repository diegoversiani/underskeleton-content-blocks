<?php

function underskeleton_ctb_register_content_block_template_simple() {
  UnderskeletonContentBlocks()->register_template( array(
      'group'              => 'content-block',
      'name'               => 'simple',
      'label'              => __('Simple', 'underskeleton_ctb' ),
    ) );
}
add_action( 'init', 'underskeleton_ctb_register_content_block_template_simple' );
