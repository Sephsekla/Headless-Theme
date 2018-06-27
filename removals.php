<?php

/**
 * Remove Post Capabilities
 */
function headless_unregister_caps() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
    unregister_taxonomy_for_object_type( 'category', 'post' );
    remove_post_type_support( 'post', 'excerpt' );
    remove_post_type_support( 'post', 'thumbnail' );
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'post', 'editor' );
}
add_action( 'init', 'headless_unregister_caps' );


/**
 * Remove Role Capabilities
 */
function headless_setup_roles(){

 $role = get_role( 'author' );

$caps = array(

);

foreach($caps as $cap){
$role->remove_cap( $cap );
}


}

add_action( 'init', 'headless_setup_roles' );

/**
 * Tidy up the dashboard
 */
function remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
}
add_action('admin_init', 'remove_dashboard_meta');


/**
 * Tidy up the admin bar
 */
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    // we can remove a menu item, like the Comments link, just by knowing the right $id
    $wp_admin_bar->remove_menu('comments');
    // or we can remove a submenu, like New Link.
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('site-name');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab

}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );



// Admin footer modification

function headless_remove_footer_admin ()
{

}

add_filter('admin_footer_text', 'headless_remove_footer_admin');



function wpb_remove_screen_options() {
if(!current_user_can('manage_options')) {
return false;
}
return true;
}
add_filter('screen_options_show_screen', 'wpb_remove_screen_options');


function disable_drag_metabox() {
    wp_deregister_script('postbox');
}
add_action( 'admin_init', 'disable_drag_metabox' );

function wpbeginner_remove_version() {
return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');

function my_footer_shh() {
    if ( ! current_user_can('manage_options') ) { // 'update_core' may be more appropriate
        remove_filter( 'update_footer', 'core_update_footer' );
    }
}
add_action( 'admin_menu', 'my_footer_shh' );
