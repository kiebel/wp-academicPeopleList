<?php

// This function reads shortcodes and act accordingly
function wpapl_shortcode( $atts ) {

	
	// For a detailed information of an idividual
	if( isset( $_GET['wpapl_id'] ) ) {
		return wpapl_showAcademicDetail( $_GET['wpapl_id'] );
	}
	// For people list
	else {
		return wpapl_showPeople( $atts );
	}

}

// Show academic detail of a praticular individual
function wpapl_showAcademicDetail( $userID ) {
	$user = wpapl_get_academic_user_info( $userID );
	$siteurl = get_option('siteurl');
	
	// Get photo URI
	$photo = wpapl_get_user_photo_uri( $userID );
	
	$top_uri = wpapl_get_uri();
	$category_uri = wpapl_get_category_uri( $user->categoryID );
	
	$html = '
		<div class="wpapl-person">
			<div class="wpapl-category-heading"><p><a href="' . $category_uri . '">' . $user->category_name . '</a> >> </p></div>
			<div class="wpapl-image"><img src="' . $photo->uri . '" width="' . $photo->width . '" height="' . $photo->height . '" /></div>
			<div class="wpapl-mininum-information">
			  <h4><span class="wpapl-person-name">' . $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name . '</span></h4>
			  <p><span class="wpapl-people-detail-tag">Job:</span> ' . $user->current_job . '<br />
				<span class="wpapl-people-detail-tag">Website:</span> ' . $user->url . '<br />
				<span class="wpapl-people-detail-tag">Email:</span> ' . $user->academic_email . '<br /><br /></p>
				<span class="wpapl-people-detail-tag">Phone Number:</span> ' . $user->phone_number . '<br />
				<span class="wpapl-people-detail-tag">Current Job:</span> ' . $user->current_job . '<br />
				<span class="wpapl-people-detail-tag">B.S. Degree:</span> ' . $user->BS_field . ', ' . $user->BS_institution . ', ' . $user->BS_year . '.<br />
				<span class="wpapl-people-detail-tag">M.S. Degree:</span> ' . $user->MS_field . ', ' . $user->MS_institution . ', ' . $user->MS_year . '.<br />
				<span class="wpapl-people-detail-tag">PhD Degree:</span> ' . $user->PhD_field . ', ' . $user->PhD_institution . ', ' . $user->PhD_year . '.<br />
				<span class="wpapl-people-detail-tag">Address:</span> ' . $user->address . '<br />
				<span class="wpapl-people-detail-tag">Bio:</span> ' . $user->bio . '<br />
				<span class="wpapl-people-detail-tag">Category:</span> ' . $user->category_name . '<br />
			</div>
			<br /><br />
			<a href="' . $top_uri . '">Go back</a>
		</div><br/>
	';	
	
	return $html;
}

// Show people list on the page
function wpapl_showPeople( $atts ) {
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
function wpapl_people_list_single_user_html( $userID ) {
	$user = wpapl_get_academic_user_info( $userID );
	$siteurl = get_option('siteurl');
	$default_image = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images/no-pic.jpg';
	
	// Get user photo
	$photo = wpapl_get_user_photo_uri( $userID );
	
	// Get user profile link
	$user_link = $current_rul = wpapl_get_uri() . "&wpapl_id=" . $userID;
	
	
	$html = '
		<div class="wpapl-person">
			<div class="wpapl-image"><img src="' . $photo->uri . '" width="' . $photo->width . '" height="' . $photo->height . '" /></div>
			<div class="wpapl-mininum-information">
			  <h4><span class="wpapl-person-name">' . $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name . '</span></h4>
			  <p><span class="wpapl-people-individual-tag">Job:</span> ' . $user->current_job . '<br />
				<span class="wpapl-people-individual-tag">Website:</span> ' . $user->url . '<br />
				<span class="wpapl-people-individual-tag">Email:</span> ' . $user->academic_email . '</p>
				<a href="' . $user_link . '">Details...</a>
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
	
	
	foreach( $all_categories as $category) {
		$html .= '<li><a href="' . wpapl_get_category_uri( $category->categoryID ) . '">' . $category->category_name . '</a></li>'; 
	}
	
	$html .= '</ul></div>';
	
	return $html;
}

?>