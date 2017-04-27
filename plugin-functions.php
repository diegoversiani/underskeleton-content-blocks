<?php

if ( !defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}



if ( !function_exists( 'underskeleton_ctb_sanitize_css' ) ) :
  
  function underskeleton_ctb_sanitize_css ( $css ) {
    $css = str_replace( '/-moz-binding/', '', $css );
    $css = str_replace( '/expression/', '', $css );
    $css = str_replace( '/javascript/', '', $css );
    $css = str_replace( '/vbscript/', '', $css );
    return $css;
  }

endif;
