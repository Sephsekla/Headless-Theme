<?php


/**
 * Rename the Posts to Email Jobs
 *
 */
function headless_edit_post_menu(){
     global $menu;
     global $submenu;

    $menu[5][0] = 'Email Jobs'; // Change posts to Email Jobs
    $submenu['edit.php'][5][0] = 'All Email Jobs';
    $submenu['edit.php'][10][0] = 'Add an Email Job';
    $submenu['edit.php'][15][0] = 'Regions'; // Rename categories to Post Codes
    //$submenu['edit.php'][16][0] = 'Areas'; // Rename tags to Areas

    remove_menu_page('tools.php'); // Remove the unused menu items
    remove_menu_page('edit-comments.php');
    remove_submenu_page('themes.php' , 'nav-menus.php'); //Remove the unused sub-menu items
    remove_submenu_page('plugins.php' , 'plugin-editor.php');
}
add_action( 'admin_menu' , 'headless_edit_post_menu' );


/**
 * Change the post type labels
 */
function headless_change_post_type_labels() {
  global $wp_post_types;

  // Get the post labels
  $postLabels = $wp_post_types['post']->labels;
  $postLabels-> name = 'Email Jobs';
  $postLabels-> singular_name = 'Email Job';
  $postLabels-> add_new = 'Add New Email Job';
  $postLabels-> add_new_item = 'Add New Email Job';
  $postLabels-> edit_item = 'Edit Email Jobs';
  $postLabels-> new_item = 'Email Jobs';
  $postLabels-> view_item = 'View Email Jobs';
  $postLabels-> search_items = 'Search Email Jobs';
  $postLabels-> not_found = 'No Email Jobs found';
  $postLabels-> not_found_in_trash = 'No Email Jobs found in Trash';
}
add_action( 'init', 'headless_change_post_type_labels' );

/**
 * Change the "Enter Title Here" text
 */
 function headless_title_text_input( $title ){
     return $title = 'Enter Email Job Title';
}
add_filter( 'enter_title_here', 'headless_title_text_input' );


add_action( 'admin_bar_menu', 'make_parent_node', 999 );

function make_parent_node( $wp_admin_bar ) {
	$args = array(
		'id'     => 'logout',     // id of the existing child node (New > Post)
		'title'  => 'Logout', // alter the title of existing node
		'parent' => false,          // set parent to false to make it a top level (parent) node
    'meta'  => array( 'class' => 'right' )
	);
	$wp_admin_bar->add_node( $args );
}

add_action( 'admin_menu', 'gowp_admin_menu' );
function gowp_admin_menu() {
  global $menu;
  foreach ( $menu as $key => $val ) {
    if ( __( 'Email Jobs') == $val[0] ) {
      $menu[$key][6] = 'dashicons-welcome-add-page';
    }
  }
}

function so_screen_layout_columns( $columns ) {
    $columns['dashboard'] = 1;
    $columns['post'] = 1;
    return $columns;
}
add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );

function so_screen_layout_dashboard() {
    return 1;
}
add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' );
add_filter( 'get_user_option_screen_layout_post', 'so_screen_layout_dashboard' );



add_action( 'admin_menu', 'headless_logout_url' );
   function headless_logout_url() {
   add_menu_page( 'sidebar_logout', 'Logout', 'read', 'my_slug', '', 'dashicons-warning', 100 );
   }

   add_action( 'admin_menu' , 'headless_logout_function' );
   function headless_logout_function() {
   global $menu;
   $menu[1][2] = wp_logout_url();
   }


   add_action('after_setup_theme', 'remove_admin_bar',10000);

   function remove_admin_bar() {
   if (!current_user_can('administrator')) {
     show_admin_bar(false);
   }
   }


   /**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'add',         // Widget slug.
                 'Add a new email brief',         // Title.
                 'addnew_widget_function' // Display function.
        );
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function addnew_widget_function() {

	// Display whatever it is you want to show.
	echo '<a href="'.admin_url().'post-new.php">Click here to add a new email job</a>';
}

function change_publish_meta_box() {
    remove_meta_box( 'submitdiv', 'post', 'side' );
    add_meta_box( 'submitdiv', 'Submit', 'post_submit_meta_box', null, 'side', 'low' );
}
add_action( 'add_meta_boxes_post',  'change_publish_meta_box' );