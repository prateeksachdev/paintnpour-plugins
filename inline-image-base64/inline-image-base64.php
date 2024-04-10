<?php
/*
Plugin Name: Inline Image Base64
Description: It gives you the possibility to inline specific images directly into the HTML as base64. Settings on every single attachment in the media library.
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Domain Path: /languages/
Version: 0.0.4
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'EOS_IIB64_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );

//Replaces the src of the attachment with a base64 encoded source.
class Eos_Inline_Image_Base64 {
  public $id;
  public function __construct(){
    add_filter( 'wp_get_attachment_image_attributes',array( $this,'img_atts' ),10,2 );
  }

  //Filter attachment attributes
  public function img_atts( $atts, $attachment ) {
    if( isset( $attachment->ID ) ){
      $this->id = $attachment->ID;
      $base64 = (bool) get_post_meta( $attachment->ID,'_eos_iib64',true );
      $not_lazy = (bool) get_post_meta( $attachment->ID,'_eos_iib64_lazy',true );
      if( $base64 ){
        $classes = isset( $atts['class'] ) ? explode( ' ',$atts['class'] ) : array();
        $classes[] = 'iib64-'.sanitize_key( $attachment->ID );
        $atts['class'] = implode( ' ',$classes );
        if( isset( $atts['srcset'] ) ){
          unset( $atts['srcset'] );
        }
        if( isset( $atts['loading'] ) ){
          unset( $atts['loading'] );
        }
        $new_src = $this->imgID2base64();
        if( $new_src ){
          $atts['src'] = $new_src;
          $this->inlined = true;
        }
      }
      if( $not_lazy && isset( $atts['loading'] ) ){
        unset( $atts['loading'] );
      }
    }
    return $atts;
  }

  //Convert source to base64
  public function imgID2base64(){
   $path = str_replace( get_home_url(),ABSPATH,wp_get_attachment_url( $this->id ) );
   if( file_exists( $path ) ){
     $type = pathinfo( $path,PATHINFO_EXTENSION );
     $data = file_get_contents( $path );
     return 'data:image/'.$type.';base64,'.base64_encode( $data );
   }
   return false;
  }
}

if( is_admin() ){
  //Code for the backend
  require_once EOS_IIB64_PLUGIN_DIR.'/admin/iib64-admin.php';
}
else{
  //Plugin initialization on the frontend
  $base64 = new Eos_Inline_Image_Base64();
}
