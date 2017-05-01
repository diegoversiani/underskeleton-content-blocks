<?php
/*
* Shortcode content-block
* Template: Simple
*/
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

  <?php if ( strtolower( $show_title ) == 'yes' ) : ?>
  <div class="<?php echo esc_attr( $title_classes ); ?>">
    <?php the_title(); ?>
  </div>
  <?php endif; ?>

  <div class="<?php echo esc_attr( $content_classes ); ?>">
    <?php 

    if ( strtolower( $show_excerpt ) == 'yes' ) {
      the_excerpt();
    }
    else {
      the_content();
    }

    ?>
  </div>

</section>
