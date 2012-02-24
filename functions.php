<?php

// Get academic information about this user
function wpapl_get_academic_user_info( $userID ) {
	global $wpapl_people_table_name, $wpdb;
	
	// Get WPAPL user data
	$user_academic_information = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpapl_people_table_name WHERE userID = %d", $userID ) );
	$user_wp_information = get_userdata( $userID );
	
	$user = $user_academic_information;
	$user->ID = $user_wp_information->ID;
	$user->user_login = $user_wp_information->user_login;
	$user->user_nicename = $user_wp_information->user_nicename;
	$user->user_email = $user_wp_information->user_email;
	$user->user_url = $user_wp_information->user_url;
	$user->user_registered = $user_wp_information->user_registered;
	$user->display_name = $user_wp_information->user_display_name;
	$user->first_name = $user_wp_information->first_name;
	$user->last_name = $user_wp_information->last_name;
	$user->nickname = $user_wp_information->nickname;
	$user->description = $user_wp_information->description;
	$user->user_level = $user_wp_information->user_level;
	$user->userphoto_thumb_file = get_option('siteurl'). '/wp-content/uploads/userphoto/' . $user_wp_information->userphoto_thumb_file;
	$user->userphoto_image_file = get_option('siteurl'). '/wp-content/uploads/userphoto/' . $user_wp_information->userphoto_image_file;
	$user->userphoto_thumb_width = $user_wp_information->userphoto_thumb_width;
	$user->userphoto_thumb_height = $user_wp_information->userphoto_thumb_height;
	
	
	return $user;
	
}

// Get current URL without the GEL parameters
function wpapl_get_uri() {
	$current_url = $_SERVER["REQUEST_URI"];
	$temp_url = explode( "&cat", $current_url );
	$current_url = $temp_url[0];
	
	return $current_url;
}




?>