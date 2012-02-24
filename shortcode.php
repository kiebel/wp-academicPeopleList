<?php

// This function reads shortcodes and act accordingly
function wpapl_shortcode( $atts ) {
	global $wpdb;
	extract( shortcode_atts( array(
		'category' => 'all',
		'show_cat' => 'true',
	), $atts ) );
	
	// If category has not been specified
	if( $category == 'all' ) {
		$cat = -1;
	}
	// If category has been specified
	else {
		$cat = $category;
	}
	
	// If category specified by URL
	if( isset( $_GET['cat'] ) ) {
		$cat = $_GET['cat'];
	}

	// Get all users under that category
	$users = wpapl_usersID_category( $cat );
	
	return  wpapl_people_category_list( $cat ) . wpapl_people_list_html( $users );

}

function wpapl_showPeople() {
	
}

// Get all users under a certain category ID
// if $categoryID = -1 then return all, otherwise return the specified categoryID
function wpapl_usersID_category( $categoryID ) {
	global $wpapl_people_table_name, $wpdb, $wpapl_category_table_name;
	
	// Fetch all people under a category
	if($categoryID == -1) {
		$all_people = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpapl_people_table_name ORDER BY %s ASC", "userID" ) );
	}
	else if( !is_numeric( $categoryID ) ) {
		$temp_res = $wpdb->get_var( $wpdb->prepare( "SELECT categoryID FROM $wpapl_category_table_name WHERE category_name = %s", $categoryID ) );
		$all_people = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpapl_people_table_name WHERE categoryID = %d ORDER BY %s ASC", $temp_res, "userID" ) );
	}
	else {
		$all_people = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpapl_people_table_name WHERE categoryID = %d ORDER BY %s ASC", $categoryID, "userID" ) ); 
	} 
	$users;
	$i = 0;
	
	foreach( $all_people as $people ) {
		$users[$i] = $people->userID;
		$i ++;
	}
	
	return $users;
}

// Return an HTML string for people list of all users
function wpapl_people_list_html( $users ) {
	if( !$users ) return '<div class="wpapl-person">Empty... </div><br />';
	
	$html = "";
	foreach( $users as $user ) {
		$html .= wpapl_people_list_single_user_html( $user );
	}
	return $html;
}

// Return an HTML string of the design of people list for each user
function wpapl_people_list_single_user_html( $user ) {
	$user = wpapl_get_academic_user_info( $user );
	$siteurl = get_option('siteurl');
	$default_image = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/no-pic.jpg';
	
	// Get user photo
	if( userphoto_exists( $user ) ) {
			$photo = $user->userphoto_thumb_file;
			$photo_width = $user->userphoto_thumb_width; 
			$photo_height = $user->userphoto_thumb_height;
		}
	else {
    		$photo =  $default_image;
    		$photo_width = 70; 
			$photo_height = 105;
		}
	
	
	$html = '
		<div class="wpapl-person">
			<div class="wpapl-image"><img src="' . $photo . '" width="' . $photo_width . '" height="' . $photo_height . '" /></div>
			<div class="wpapl-mininum-information">
			  <h4><span class="wpapl-person-name">' . $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name . '</span></h4>
			  <p><strong>Job:</strong> ' . $user->current_job . '<br />
				<strong>Website:</strong> ' . $user->url . '<br />
				<strong>Email:</strong> ' . $user->academic_email . '</p>
			</div>
		</div><br/>
	';
	
	return $html;
}

// Return HTML string of academic people category list
function wpapl_people_category_list( $current_categoryID = -1 ) {
	global $wpapl_category_table_name, $wpdb;
	
	$all_categories = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpapl_category_table_name ORDER BY %s ASC", "category_name" ) ); 
	$html = '<div id="wpapl-category-list-navmenu"><ul>';
	
	$current_rul = wpapl_get_uri();
	
	foreach( $all_categories as $category) {
		$html .= '<li><a href="' . $current_url . '&cat=' . $category->categoryID . '">' . $category->category_name . '</a></li>'; 
	}
	
	$html .= '</ul></div>';
	
	return $html;
}

?>