<?php
/*
Plugin Name: Membership Badges
Plugin URI: 
Description: Membership Badges
Version: 1.0
Author: samrat
Author URI: 
License: GPL2
*/ 

//print_r($_REQUEST);

$pluginsURI = plugins_url('/membership-badge/');

if (isset($_POST['badge_id'])) {
	
	if (is_numeric($_POST['badge_id'])) {
			
			$table_name = $wpdb->prefix . "membership_badge_request";
	
			$insert = "INSERT INTO " . $table_name .
			" (badge_id, user_id, user_request, created_at) " .
			"VALUES (" . 
			$_REQUEST['badge_id']. "," . 
			$_REQUEST['user_id']. ",'" . 
			$wpdb->escape($_REQUEST['user_request']). "','" . 
			time() . "'" . 
			")";
			//echo $insert;
			$results = $wpdb->query( $insert );
			
			if (!$results)
				$err .= "Fail to update database" . "<br />";
			else
				$msg .= "Your request for badge submited" . "<br />";
		
	}

}

if (isset($_POST['submit_button'])) {

	if ($_POST['action'] == 'update' and $_POST['section'] == 'badge')
	{
	
		$err = "";
		$msg = "";
		
		$image_file_path = "../wp-content/uploads/";
		
			if ($_FILES["image_file"]["name"] != "" ){
			
				if( 
					($_FILES["image_file"]["type"] == "image/gif")
				|| ($_FILES["image_file"]["type"] == "image/jpeg")
				|| ($_FILES["image_file"]["type"] == "image/pjpeg")
				|| ($_FILES["image_file"]["type"] == "image/png")
				&& ($_FILES["image_file"]["size"] < 1024*1024*1))
				  {
					if ($_FILES["image_file"]["error"] > 0)
					{
						$err .= "Return Code: " . $_FILES["image_file"]["error"] . "<br />";
					}
				  else
					{
					if (file_exists($image_file_path . $_FILES["image_file"]["name"]))
					  {
					  $err .= $_FILES["image_file"]["name"] . " already exists. ";
					  }
					else
					  {
						$image_file_name = time().'_'.$_FILES["image_file"]["name"];
						$fstatus = move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path . $image_file_name);
						if ($fstatus == true){
							$msg = "File upload successful"."<br />";
						}
					  }
					}
				  }
				else
				{
					$err .= "Invalid file type or max file size exceded" . "<br />";
				}
			}
			else
			{
				$err .= "Please input image file". "<br />";
			}// end if image file
			
			$image_file2 = $_FILES["image_file2"];
			if ($image_file2["name"] != "" ){
			
				if( 
				   ($image_file2["type"] == "image/gif")
				|| ($image_file2["type"] == "image/jpeg")
				|| ($image_file2["type"] == "image/pjpeg")
				|| ($image_file2["type"] == "image/png")
				&& ($image_file2["size"] < 1024*1024*1))
				  {
					if ($image_file2["error"] > 0)
					{
						$err .= "Return Code: " . $image_file2["error"] . "<br />";
					}
				  else
					{
					if (file_exists($image_file_path . $image_file2["name"]))
					  {
					  $err .= $image_file2["name"] . " already exists. ";
					  }
					else
					  {
						$image_file_name2 = time().'_'.$image_file2["name"];
						$fstatus = move_uploaded_file($image_file2["tmp_name"], $image_file_path . $image_file_name2);
						if ($fstatus == true){
							$msg = "File upload successful"."<br />";
						}
					  }
					}
				  }
				else
				{
					$err .= "Invalid file type or max file size exceded" . "<br />";
				}
			}
			else
			{
				$err .= "Please input image file". "<br />";
			}// end if image file2
			
		
		if ($err == '')
		{
			$table_name = $wpdb->prefix . "membership_badge";
	
			$insert = "INSERT INTO " . $table_name .
			" (cat_id, title, description, description2, image_url, image_url2, sortorder, date_upload) " .
			"VALUES (" . 
			$_REQUEST['cat_id']. ",'" . 
			$wpdb->escape( $_REQUEST['title']) . "','" . 
			$wpdb->escape( $_REQUEST['description']) . "','" . 
			$wpdb->escape( $_REQUEST['description2']) . "','" . 
			$image_file_name . "','" . 
			$image_file_name2 . "'," . 
			$_REQUEST['sortorder'] . ",'" . 
			time() . "'" . 
			")";
			$results = $wpdb->query( $insert );
			
			if (!$results)
				$err .= "Fail to update database" . "<br />";
			else
				$msg .= "Update successful" . "<br />";
		
		}
	}// end if update
	
	if ($_POST['action'] == 'update' and $_POST['section'] == 'category')
	{
	
		$err = "";
		$msg = "";
		
		if ($err == '')
		{
			$table_name = $wpdb->prefix . "membership_badge_category";
	
			$insert = "INSERT INTO " . $table_name .
			" (title, description, sortorder, date_upload) " .
			"VALUES ('" . 
			$wpdb->escape( $_REQUEST['title']) . "','" . 
			$wpdb->escape( $_REQUEST['description']) . "'," . 
			$_REQUEST['sortorder'] . ",'" . 
			time() . "'" . 
			")";
			$results = $wpdb->query( $insert );
			
			if (!$results)
				$err .= "Fail to update database" . "<br />";
			else
				$msg .= "Update successful" . "<br />";
		
		}
	}// end if update cat
	
	
	if ( $_REQUEST['action'] == 'edit' and $_REQUEST['id'] != '' and $_POST['section'] == 'badge' )
	{
		$err = "";
		$msg = "";

		$description = $_REQUEST['description'];
		$description2 = $_REQUEST['description2'];
		
		$image_file_path = "../wp-content/uploads/";
		$table_name = $wpdb->prefix . "membership_badge";
		$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
		$video_info = $wpdb->get_results($sql);
		$image_file_name = $video_info[0]->image_url;
		$image_file_name2 = $video_info[0]->image_url2;
		$update = "";
		
		$imgExtArray = array('image/gif','image/jpeg','image/pjpeg','image/png');
		
		if ($_FILES["image_file"]["name"] != ""){
			if( in_array($_FILES["image_file"]["type"],$imgExtArray) && $_FILES["image_file"]["size"] <= 1024*1024*1 )
			{
				if ($_FILES["image_file"]["error"] > 0)
				{
					$err .= "Return Code: " . $_FILES["image_file"]["error"] . "<br />";
				}
			  else
				{
				if (file_exists($image_file_path . $_FILES["image_file"]["name"]))
				  {
				  $err .= $_FILES["image_file"]["name"] . " already exists. ";
				  }
				else
				  {
					$image_file_name = time().'_'.$_FILES["image_file"]["name"];
					$fstatus = move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path . $image_file_name);
					
					if ($fstatus == true){
						$msg = "File Uploaded Successfully!!!".'<br />';
						@unlink($image_file_path.$video_info[0]->image_url);
						$update = "UPDATE " . $table_name . " SET " . 
						"image_url='" .$image_file_name . "'" . 
						" WHERE id=" . $_REQUEST['id'];
						$results1 = $wpdb->query( $update );
					}
				  }
				}
			  }
			else
			{
				$err .= "Invalid file type or max file size exceded";
			}
		}
		
		$image_file2 = $_FILES["image_file2"];
		if ($image_file2["name"] != ""){
			if( in_array($image_file2["type"],$imgExtArray) && $image_file2["size"] <= 1024*1024*1 )
			{
				if ($image_file2["error"] > 0)
				{
					$err .= "Return Code: " . $image_file2["error"] . "<br />";
				}
			  else
				{
				if (file_exists($image_file_path . $image_file2["name"]))
				  {
				  $err .= $image_file2["name"] . " already exists. ";
				  }
				else
				  {
					$image_file_name2 = time().'_'.$image_file2["name"];
					$fstatus = move_uploaded_file($image_file2["tmp_name"], $image_file_path . $image_file_name2);
					
					if ($fstatus == true){
						$msg = "File Uploaded Successfully!!!".'<br />';
						@unlink($image_file_path.$video_info[0]->image_url2);
						$update = "UPDATE " . $table_name . " SET " . 
						"image_url2='" .$image_file_name2 . "'" . 
						" WHERE id=" . $_REQUEST['id'];
						$results1 = $wpdb->query( $update );
					}
				  }
				}
			  }
			else
			{
				$err .= "Invalid file type or max file size exceded";
			}
		}
		
		$update = "UPDATE " . $table_name . " SET " . 
		"cat_id=" .$_POST['cat_id']. "," . 
		"title='" .$wpdb->escape( $_POST['title']) . "'," . 
		"description='" . $description. "'," . 
		"description2='" . $description2. "'," . 
		"sortorder=" .$_POST['sortorder'] . "," . 
		"date_upload='" .time(). "'" . 
		" WHERE id=" . $_POST['id'];
		if ($err == '')
		{
			$results3 = $wpdb->query( $update );
			
			if (!$results3){
				$err .= "Update Fail!!!". "<br />";
			}
			else
			{
				$msg = "Update successful". "<br />";
			}
		}
		
	} // end edit cat
	
	if ( $_REQUEST['action'] == 'edit' and $_REQUEST['id'] != '' and $_POST['section'] == 'category' )
	{
		$err = "";
		$msg = "";

		$description = $_REQUEST['description'];
		
		$table_name = $wpdb->prefix . "membership_badge_category";
		$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
		$video_info = $wpdb->get_results($sql);
		$update = "";
		
		$update = "UPDATE " . $table_name . " SET " . 
		"title='" .$wpdb->escape( $_POST['title']) . "'," . 
		"description='" . $description. "'," . 
		"sortorder=" .$_POST['sortorder'] . "," . 
		"date_upload='" .time(). "'" . 
		" WHERE id=" . $_POST['id'];
		if ($err == '')
		{
			$results3 = $wpdb->query( $update );
			
			if (!$results3){
				$err .= "Update Fail!!!". "<br />";
			}
			else
			{
				$msg = "Update successful". "<br />";
			}
		}
		
	} // end edit cat
	
	
}

if (isset($_GET['delete'])) {
	if ($_REQUEST['id'] != '')
	{
		$table_name = $wpdb->prefix . "membership_badge";
		$table_name_req = $wpdb->prefix . "membership_badge_request";
		
		$image_file_path = "../wp-content/uploads/";
		$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
		$video_info = $wpdb->get_results($sql);
		
		if (!empty($video_info))
		{
			@unlink($image_file_path.$video_info[0]->image_url);
			@unlink($image_file_path.$video_info[0]->image_url2);
		}
		$delete = "DELETE FROM ".$table_name." WHERE id = ".$_REQUEST['id']." LIMIT 1";
		$results = $wpdb->query( $delete );
		
		$delete = "DELETE FROM ".$table_name_req." WHERE badge_id = ".$_REQUEST['id']." LIMIT 1";
		$results = $wpdb->query( $delete );
		
		$msg = "Delete successful"."<br />";
	}
}

if (isset($_GET['approve'])) {
	if ($_REQUEST['id'] != '')
	{
		$table_name = $wpdb->prefix . "membership_badge_request";
		$update = "UPDATE ".$table_name." SET approve=1 WHERE badge_id = ".$_REQUEST['id']."";
		$results = $wpdb->query( $update );
		$msg = "Badge request approved"."<br />";
	}
}
if (isset($_GET['deny'])) {
	if ($_REQUEST['id'] != '')
	{
		$table_name = $wpdb->prefix . "membership_badge_request";
		$delete = "DELETE FROM ".$table_name." WHERE badge_id = ".$_REQUEST['id']." LIMIT 1";
		$results = $wpdb->query( $delete );
		$msg = "Badge request denied"."<br />";
	}
}

function mb_db_install () {
   global $wpdb;

   $table_name = $wpdb->prefix . "membership_badge";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT, 
		`cat_id` INT NOT NULL,
		`title` VARCHAR(255) NULL, 
		`description` TEXT NULL, 
		`description2` TEXT NULL, 
		`image_url` VARCHAR(255) NOT NULL, 
		`image_url2` VARCHAR(255) NOT NULL, 
		`sortorder` INT NOT NULL DEFAULT '0', 
		`date_upload` VARCHAR(100) NULL, 
		PRIMARY KEY (`id`)) ENGINE = InnoDB";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
   }
   
   $table_name = $wpdb->prefix . "membership_badge_category";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT, 
		`title` VARCHAR(255) NULL, 
		`description` TEXT NULL, 
		`sortorder` INT NOT NULL DEFAULT '0', 
		`date_upload` VARCHAR(100) NULL, 
		PRIMARY KEY (`id`)) ENGINE = InnoDB";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

   $table_name = $wpdb->prefix . "membership_badge_request";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	
		$sql = "CREATE TABLE " . $table_name . " (
		`badge_id` INT NOT NULL ,
		`user_id` INT NOT NULL ,
		`approve` TINYINT NOT NULL ,
		`user_request` TEXT NULL, 
		`created_at` VARCHAR( 100 ) NULL
		) ENGINE = InnoDB;";
	}

}
register_activation_hook(__FILE__,'mb_db_install');

function mb_add_themescript(){
    if(!is_admin()){
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox',null,array('jquery'));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
    }
     
}
add_action('init','mb_add_themescript');

add_action('admin_menu', 'mb_add_menu_pages');

function mb_add_menu_pages() {
	add_menu_page('Membership Badges', 'Badges', 'manage_options', 'mb_membership_badges_page', 'mb_membership_badges_page_fn', plugins_url('/images/mb-icon.png', __FILE__) );
	
	add_submenu_page('mb_membership_badges_page', 'Manage Badges', 'Manage Badges', 'manage_options', 'mb_membership_badges_page', 'mb_membership_badges_page_fn');
	
	add_submenu_page('mb_membership_badges_page', 'Add Category', 'Add Category', 'manage_options', 'mb_membership_badges_addcat', 'mb_membership_badges_addcat_fn');
	
add_submenu_page('mb_membership_badges_page', 'Add Badges', 'Add Badges', 'manage_options', 'mb_membership_badges_addnew', 'mb_membership_badges_addnew_fn');	
	
	add_submenu_page('mb_membership_badges_page', 'Manage Category', 'Manage Category', 'manage_options', 'mb_membership_badges_managecat', 'mb_membership_badges_managecat_fn');
	
	add_submenu_page('mb_membership_badges_page', 'Review', 'Review', 'manage_options', 'mb_membership_badges_review', 'mb_membership_badges_review_fn');
	
	add_submenu_page('mb_membership_badges_page', 'Badge Settings', 'Badge Settings', 'manage_options', 'mb_membership_badges_settings', 'mb_membership_badges_settings_fn');
	
	add_action( 'admin_init', 'register_mb_settings' );
}

function register_mb_settings() {
	register_setting( 'mb-settings-group', 'mb-badge-page-width' );
	register_setting( 'mb-settings-group', 'mb-bgcolor' );
	register_setting( 'mb-settings-group', 'mb-padding' );
	register_setting( 'mb-settings-group', 'mb-num-badge-count' );
}

function mb_membership_badges_settings_fn() {
	
	$page_width = get_option('mb-badge-page-width');
	$mb_bgcolor = get_option('mb-bgcolor');
	$mb_padding = get_option('mb-padding');
	$mb_num_badge = get_option('mb-num-badge-count');
	?>
	<div class="wrap">
	<h2>Badge Options</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'mb-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">badge page Width</th>
			<td><input type="text" name="mb-badge-page-width" id="mb-badge-page-width" class="small-text" value="<?php echo $page_width?>" />px</td>
			</tr>
			<tr valign="top">
			<th scope="row">Background color</th>
			<td><input type="text" name="mb-bgcolor" id="mb-bgcolor" class="small-text" value="<?php echo $mb_bgcolor?>" /></td>
			</tr>
			<tr valign="top">
			<th scope="row">Padding</th>
			<td><input type="text" name="mb-padding" id="mb-padding" class="small-text" value="<?php echo $mb_padding?>" />px</td>
			</tr>

			<tr valign="top">
			<th scope="row">Number of badge</th>
			<td><input type="text" name="mb-num-badge-count" id="mb-num-badge-count" class="small-text" value="<?php echo $mb_num_badge?>" />per row</td>
			</tr>
			
		</table>
		
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	</div>
<?php 
}

function mb_membership_badges_review_fn() {
	include('mb_review.php');
}  

function mb_membership_badges_addcat_fn() {
	include('mb_addcat.php');
}  

function mb_membership_badges_addnew_fn() {
	include('mb_addnew_badge.php');
}  

function mb_membership_badges_managecat_fn() {
	include('mb_manage_category.php');
}

function mb_membership_badges_page_fn() {
	include('mb_manage_badge.php');
}

function mb_display_badge($atts) {
	ob_start();
	include('mb_display_badge.php');
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

add_shortcode('badge', 'mb_display_badge');