<?php
/**
 * Index Page
 *
 * Front end display/redirection
 *
 * @package headless
 *
 * @since 0.0.1
 */

?>


<!DOCTYPE HTML>
<html>
<head>

<?php
do_action( 'wp_head' );
?>
</head>
<body>
<?php

$post_ID = get_the_id();


if ( is_front_page() ) {

	$url = get_admin_url();
	$red = '';
} elseif ( get_post_type( $post_ID ) === 'post' ) {

	$url = get_edit_post_link( $post_ID, false );
	$red = get_permalink( $post_ID );
} else {

	$url = get_admin_url();

}



if ( is_user_logged_in() ) {
	wp_safe_redirect( $url );
	exit;
} else {

	wp_safe_redirect( wp_login_url( $red ) );
	exit;

}



do_action( 'wp_footer' );
?>
</body>
</html>
