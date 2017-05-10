<?php
/*
* Plugin main class
*/

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class UnderskeletonContentBlocks {
  
  protected static $_instance = null;

  protected $templates = array();

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }




  public function get_templates() {
    return $this->templates;
  }




  public function register_template( $template_args ) {
    if ( !is_array( $template_args ) ) {
      trigger_error( 'Wrong type for `$template_args`, should be array.', E_USER_NOTICE );
      exit;
    }

    if ( !array_key_exists( 'group', $template_args ) ) {
      trigger_error( 'Missing template group name.', E_USER_NOTICE );
      exit;
    }

    if ( !array_key_exists( 'name', $template_args ) ) {
      trigger_error( 'Missing template name.', E_USER_NOTICE );
      exit;
    }

    if ( !array_key_exists( 'label', $template_args ) ) {
      $template_args = $template_args['name'];
    }



    $template_id = sprintf( '%s-%s', $template_args['group'], $template_args['name'] );

    if ( array_key_exists( $template_id, $this->templates ) ) {
      trigger_error( 'Template "' . $template_id . '" already exists.', E_USER_NOTICE );
      exit;
    }

    $template_args['id'] = $template_id;
    $this->templates[ $template_id ] = $template_args;

  }




  public function locate_template( $group, $name = 'simple', $path = null ) {
    $template = '';

    // look in theme directory
    if ( empty( $template ) ) {
      $template = locate_template( sprintf( '%1$s%2$s-%3$s.php',
      UNDERSKELETON_CONTENT_BLOCKS_THEME_TEMPLATES_FOLDER,
      $group,
      $name ) );
    }

    // look in custom path
    if ( empty( $template ) && !empty( $path ) ) {
      $template = locate_template( sprintf( '%1$s%2$s-%3$s.php',
      $path,
      $group,
      $name ) );
    }

    // fall back to plugin template directory
    if ( empty( $template ) || !file_exists( $template ) ) {
      if ( $name != 'simple' ) {
        trigger_error("Content Blocks: Template '{$name}' not found, using 'simple' instead.", E_USER_NOTICE);
        $name = 'simple';
      }

      $template = sprintf( '%1$s%2$s-%3$s.php',
      UNDERSKELETON_CONTENT_BLOCKS_TEMPLATES_FOLDER,
      $group,
      $name );
    }

    return $template;
  }

}



function UnderskeletonContentBlocks() {
  return UnderskeletonContentBlocks::instance();
}
