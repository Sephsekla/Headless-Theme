<?php

require_once('removals.php');
require_once('additions.php');



/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function wpdocs_enqueue_custom_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style',10000 );


add_action('admin_head',function(){
?>
<style>
#wpadminbar{display: none !important;}
</style>
<?php
});


add_action('publish_post','send_brief',2);


function send_brief($ID,$post){

  $attachments = array();

$content ='
<h1>New Email Job Added</h1>

';

wp_mail('developer@fluroltd.com','New Email Job Added',$content,"",$attachments);

}
