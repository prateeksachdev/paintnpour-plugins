<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly


add_filter('attachment_fields_to_edit', 'eos_iib64_add_image_attachment_fields_to_edit', null, 2);
//Add custom checkbox to activate the base64 encoding of the attachment
function eos_iib64_add_image_attachment_fields_to_edit( $form_fields, $post ) {
  $path = str_replace( get_home_url(),ABSPATH,wp_get_attachment_url( $post->ID ) );
  if( file_exists( $path ) ){
    $filesize = filesize( $path );
    $checkbox_field = (bool) get_post_meta( $post->ID,'_eos_iib64_lazy',true );
  	$form_fields['eos_iib64_lazy'] = array(
  		'label' => esc_html__( 'Native lazy loading','eos-iib64' ),
      'input' => 'html',
      'html' => '<div style="margin-top:8px"><input style="margin-top:0" type="checkbox" id="attachments-'.esc_attr( $post->ID ).'-eos_iib64-lazy" name="attachments['.esc_attr( $post->ID ).'][eos_iib64_lazy]" value="1"'.( !$checkbox_field ? ' checked="checked"' : '' ).' /> <span class="eos-iib64-txt">'.esc_html__( 'If unchecked this image will never be lazy loaded.','eos-iib64').'</span></div>',
  		'helps' => '',
  	);
    $checkbox_field = (bool) get_post_meta( $post->ID,'_eos_iib64',true );
    $warning = '';
    if( absint( $filesize ) > 50000 ){
      $kb = absint( 0.000977 * $filesize );
      $warning = '<div id="iib64-warning" style="display:'.( $checkbox_field ? 'block' : 'none' ).'" class="notice notice-warning">'.sprintf( esc_html__( "The size of this image is %skB, the HTML may become too big if you inline this image. Better you don't inline images bigger than 20 kB. Let's say until 30-40 kB it may still be ok if your HTML isn't already big, but %s are too much.",'eos-iib64' ),$kb,$kb ).' </div>';
    }
    $warning .= '<script>function eos_iib64_toggle_warning(){var w = document.getElementById("iib64-warning");if(w){w.style.display = "block" === w.style.display ? "none" : "block";}};</script>';
  	$form_fields['eos_iib64'] = array(
  		'label' => esc_html__( 'Inline image','eos-iib64' ),
      'input' => 'html',
      'html' => '<div style="margin-top:8px"><input style="margin-top:0" type="checkbox" onclick="eos_iib64_toggle_warning();" id="attachments-'.esc_attr( $post->ID ).'-eos_iib64" name="attachments['.esc_attr( $post->ID ).'][eos_iib64]" value="1"'.( $checkbox_field ? ' checked="checked"' : '' ).' /> <span class="eos-iib64-txt">'.esc_html__( 'If checked the image will be inlined inside the HTML.','eos-iib64').'</span>'.$warning .'</div>',
  		'helps' => '',
  	);
  }
	return $form_fields;
}

add_filter('attachment_fields_to_save', 'eos_iib64_add_image_attachment_fields_to_save', null , 2);
//Save custom media metadata fields
function eos_iib64_add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['eos_iib64_lazy'] ) ){
    delete_post_meta( absint( $post['ID'] ),'_eos_iib64_lazy' );
  }
  if( !isset( $attachment['eos_iib64_lazy'] ) || !$attachment['eos_iib64_lazy'] ){
    update_post_meta( absint( $post['ID'] ), '_eos_iib64_lazy',1 );
  }
	if ( isset( $attachment['eos_iib64'] ) ){
		update_post_meta( absint( $post['ID'] ), '_eos_iib64', sanitize_text_field( $attachment['eos_iib64'] ) );
  }
  if( !isset( $attachment['eos_iib64'] ) || !$attachment['eos_iib64'] ){
    delete_post_meta( absint( $post['ID'] ),'_eos_iib64' );
  }
	return $post;
}
