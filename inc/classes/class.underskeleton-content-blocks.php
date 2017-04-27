<?php
/*
* Plugin main class
*/

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class UnderskeletonContentBlocks {
  
  protected static $_instance = null;

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }





  public function locate_template( $name, $variant = 'default', $path = null ) {
    $template = '';

    // look in theme directory
    if ( empty( $template ) ) {
      $template = locate_template( sprintf( '%1$s%2$s-%3$s.php',
      UNDERSKELETON_CONTENT_BLOCKS_THEME_TEMPLATES_FOLDER,
      $name,
      $variant ) );
    }

    // look in custom path
    if ( empty( $template ) && !empty( $path ) ) {
      $template = locate_template( sprintf( '%1$s%2$s-%3$s.php',
      $path,
      $name,
      $variant ) );
    }

    // fall back to plugin template directory
    if ( empty( $template ) || !file_exists( $template ) ) {
      $template = sprintf( '%1$s%2$s-%3$s.php',
      UNDERSKELETON_CONTENT_BLOCKS_TEMPLATES_FOLDER,
      $name,
      $variant );
    }

    return $template;
  }

}



function UnderskeletonContentBlocks() {
  return UnderskeletonContentBlocks::instance();
}
