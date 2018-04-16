<?php

	global $err,$msg,$wpdb;
	
	$table_name_cat = $wpdb->prefix . "membership_badge_category";
	$sql = "SELECT * FROM ".$table_name_cat." WHERE 1";
	$video_info_cat = $wpdb->get_results($sql);
	

	if (isset($_GET['mode'])) {
		if ( $_REQUEST['mode'] != '' and $_REQUEST['mode'] == 'edit' and  $_REQUEST['id'] != '' )
		{
		
			$page_title = 'Edit Badge';
			$uptxt = 'Upload Inactive Badge';
			$uptxt2 = 'Upload Active Badge';
			
			global $wpdb;
			$table_name = $wpdb->prefix . "membership_badge";
			$image_file_path = "../wp-content/uploads/";
			$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
			$video_info = $wpdb->get_results($sql);
			
			if (!empty($video_info))
			{
				$id = $video_info[0]->id;
				$title = $video_info[0]->title;
				$cat_id = $video_info[0]->cat_id;
				
				$description = $video_info[0]->description;
				$description2 = $video_info[0]->description2;
				
				$image_url = $image_file_path.$video_info[0]->image_url;
				$image_url2 = $image_file_path.$video_info[0]->image_url2;
				
				$sortorder = $video_info[0]->sortorder;
			}
		}
	}
	else
	{
	
		$page_title = 'Add New Badge';
		$title = "";
		$image_url = "";
		$sortorder = "0";
		$description = "";
		$description2 = "";
		$uptxt = 'Upload Inactive Badge';
		$uptxt2 = 'Upload Active Badge';
	
	}
?>
<div class="wrap">
<?php
if($msg!='' or $err!='')
	echo '<div id="message" class="updated fade">'. $msg.$err.'</div>';
?>

<h2><?php echo $page_title;?></h2>

<form method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    
    <table class="form-table">
	
	
	
        <tr valign="top">
			<th scope="row">Select Category</th>
			<td>
				<select name="cat_id" id="cat_id">
				<?php
				foreach($video_info_cat as $cat)
				{
				?>
					<option <?php if($cat->id == $cat_id) echo 'selected="selected"'; ?> value="<?php echo $cat->id; ?>"><?php echo $cat->title; ?></option>
				<?php
				}
				?>
				</select>
			</td>
        </tr>
	
	
        <tr valign="top">
			<th scope="row">Badge Name</th>
			<td>
				<input type="text" name="title" id="title" class="regular-text" value="<?php echo $title?>" />
			</td>
        </tr>
		
        <tr valign="top">
			<th scope="row"><?php echo $uptxt;?></th>
			<td>
				<?php if (isset($_GET['mode'])) { ?>
					<br /><img src="<?php echo $image_url?>" border="0" width="195"  height="" /><br />
				<?php } ?>
				<input type="file" name="image_file" id="image_file" value="" />
			</td>
        </tr>
		
        <tr valign="top">
			<th scope="row"><?php echo $uptxt2;?></th>
			<td>
				<?php if (isset($_GET['mode'])) { ?>
					<br /><img src="<?php echo $image_url2?>" border="0" width="195"  height="" /><br />
				<?php } ?>
				<input type="file" name="image_file2" id="image_file2" value="" />
			</td>
        </tr>
		
        <tr valign="top">
			<th scope="row">Badge Description for Unaccomplished goals</th>
			<td><textarea name="description" id="description" class="large-text"><?php echo $description ?></textarea></td>
        </tr>
		
        <tr valign="top">
			<th scope="row">Badge Description for Accomplished Goals</th>
			<td><textarea name="description2" id="description2" class="large-text"><?php echo $description2 ?></textarea></td>
        </tr>
		
		
        <tr valign="top">
			<th scope="row">Sort Order</th>
			<td>
				<input type="text" name="sortorder" id="sortorder" class="small-text" value="<?php echo $sortorder?>" />
			</td>
        </tr>
    </table>
	<?php if (isset($_GET['mode']) ) { ?>
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
	<input type="hidden" name="section" value="badge" />
	<?php } else {?>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="section" value="badge" />
	<?php } ?>
    <p class="submit">
    <input type="submit" name="submit_button" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php 
