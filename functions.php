<?php

require_once 'removals.php';
require_once 'additions.php';



/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function wpdocs_enqueue_custom_admin_style() {
		wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style', 10000 );


add_action(
	'admin_head', function() {
		?>
<style>
#wpadminbar{display: none !important;}
</style>
		<?php
	}
);

function my_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
	// wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

add_action( 'publish_post', 'send_brief', 2 );


function send_brief( $ID, $post ) {

	$attachments = array();

	$emails = array();

	if ( have_rows( 'notification_emails', 'option' ) ) {
		while ( have_rows( 'notification_emails', 'option' ) ) {

			the_row();

			$emails[] = get_sub_field( 'email_address' );

		}
	}

	if ( have_rows( 'email_notifications', $ID ) ) {
		while ( have_rows( 'email_notifications', $ID ) ) {

			the_row();

			$emails[] = get_sub_field( 'email' );

		}
	}

	$authoremail = get_the_author_meta( 'user_email' );

	if ( ! in_array( $authoremail, $emails ) ) {

		$emails[] = $authoremail;

	}

	$content = '
<h1>New Email Job Added</h1>

<h2>' . get_the_title( $ID ) . '</h2>

<p>Deadline for first draft: ' . get_field( 'deadline_for_first_draft', $ID ) . '
<br>Deadline for final HTML: ' . get_field( 'deadline_for_final HTML', $ID ) . '
<br>Total number of emails: ' . count( get_field( 'emails', $ID ) ) . '
<br>Added by ' . get_the_author_meta( 'user_nicename' ) . '</p>
<p>For more information <a href="' . get_permalink( $ID ) . '">click here</a></p>

';

	wp_mail( array( $emails ), 'New Email Job Added', $content, array( 'Content-type: text/html' ), $attachments );

}


// Function to change email address
function wpb_sender_email( $original_email_address ) {
	return 'studio@fluroltd.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
	return 'Gartner Email Briefs';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

/*
add_filter('login_form_defaults',function($args){

$args['remember'] = false;
$args['label_username'] = 'Test';
return $args;

},100000,1);*/


// changing the logo link from wordpress.org to your site
function my_login_url() {
	return home_url(); }

// changing the alt text on the logo to show your site name
function my_login_title() {
	return 'Gartner'; }

// calling it only on the login page
add_filter( 'login_headerurl', 'my_login_url' );
add_filter( 'login_headertitle', 'my_login_title' );
