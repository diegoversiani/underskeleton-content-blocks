<?php

if ( !function_exists( 'underskeleton_ctb_get_boolean_value' ) ) :

  function underskeleton_ctb_get_boolean_value( $string ) {
    return in_array($string, array('true', 'True', 'TRUE', 'yes', 'Yes', 'y', 'Y', '1', 'on', 'On', 'ON', true, 1), true);
  }

endif;



if ( !function_exists( 'underskeleton_ctb_sanitize_css' ) ) :
  
  function underskeleton_ctb_sanitize_css ( $css ) {
    $css = str_replace( '/-moz-binding/', '', $css );
    $css = str_replace( '/expression/', '', $css );
    $css = str_replace( '/javascript/', '', $css );
    $css = str_replace( '/vbscript/', '', $css );
    return $css;
  }

endif;