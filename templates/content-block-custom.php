<?php
/*
* Shortcode content-block custom template
*/

$gradient_style = sprintf( 'style="background: %1$s;
  background: -webkit-linear-gradient(%1$s, %2$s);
  background: -o-linear-gradient(%1$s, %2$s);
  background: -moz-linear-gradient(%1$s, %2$s);
  background: linear-gradient(%1$s, %2$s);"',
  $block_options['color_1'],
  $block_options['color_2']
  );

?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>" <?php echo $gradient_style ?>>

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
