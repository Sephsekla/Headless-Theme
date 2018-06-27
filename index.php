<?php


if(is_user_logged_in()){
wp_safe_redirect(get_admin_url());
exit;
}
else{

wp_safe_redirect(site_url().'/email-login');
exit;

}
