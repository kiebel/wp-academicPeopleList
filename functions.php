<?php

// Get academic information about this user
function wpapl_get_academic_user_info( $userID ) {
	global $wpapl_people_table_name, $wpdb, $wpapl_category_table_name;
	
	// Get WPAPL user data
	$user_academic_information = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpapl_people_table_name WHERE userID = %d", $userID ) );
	$user_wp_information = get_userdata( $userID );
	$user_category = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpapl_category_table_name WHERE categoryID = %d", $user_academic_information->categoryID ) );
	
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
	$user->categoryID = $user_academic_information->categoryID;
	$user->category_name = $user_category->category_name;
	
	
	return $user;
	
}

// Get current URL without the GEL parameters
function wpapl_get_uri() {
	$current_url = $_SERVER["REQUEST_URI"]; 
	$temp_url = explode( "&cat", $current_url );
	$current_url = $temp_url[0];
	$temp_url = explode( "&wpapl_id", $current_url );
	$current_url = $temp_url[0];
	
		
	return $current_url;
}

// Get category URI
function wpapl_get_category_uri( $categoryID ) {
	$current_url = wpapl_get_uri();
	
	$category_uri = $current_url . '&cat=' . $categoryID;
	
	return $category_uri;
}


// Get photo of a certain user
function wpapl_get_user_photo_uri( $userID ) {
	// Get user details
	$user = wpapl_get_academic_user_info( $userID );
	
	// URI of the default photo
	$default_image = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/no-pic.jpg';
	
	// Get user photo
	if( function_exists( 'userphoto_exists' ) && userphoto_exists( $userID ) ) {
			$photo_uri = $user->userphoto_thumb_file;
			$photo_width = $user->userphoto_thumb_width; 
			$photo_height = $user->userphoto_thumb_height;
		}
	else {
    		$photo_uri =  $default_image;
    		$photo_width = 70; 
			$photo_height = 105;
		}
		
	$photo->uri = $photo_uri;
	$photo->width = $photo_width;
	$photo->height = $photo_height;
	
	return $photo;
}


?>