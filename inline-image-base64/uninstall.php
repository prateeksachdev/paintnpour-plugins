<?php
if( !defined( 'WP_UNINSTALL_PLUGIN') ){
    die;
}
delete_post_meta_by_key( '_eos_iib64_lazy' );
delete_post_meta_by_key( '_eos_iib64' );
