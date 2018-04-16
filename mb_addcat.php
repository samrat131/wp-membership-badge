<?php

	global $err,$msg;

	if (isset($_GET['mode'])) {
		if ( $_REQUEST['mode'] != '' and $_REQUEST['mode'] == 'edit' and  $_REQUEST['id'] != '' )
		{
		
			$page_title = 'Edit Category';
			
			global $wpdb;
			$table_name = $wpdb->prefix . "membership_badge_category";
			//$image_file_path = "../wp-content/uploads/";
			$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
			$video_info = $wpdb->get_results($sql);
			
			if (!empty($video_info))
			{
				$id = $video_info[0]->id;
				$title = $video_info[0]->title;
				$description = $video_info[0]->description;
				$sortorder = $video_info[0]->sortorder;
			}
		}
	}
	else
	{
	
		$page_title = 'Add New Category';
		$title = "";
		$sortorder = "0";
		$description = "";
	
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
			<th scope="row">Category Name</th>
			<td>
				<input type="text" name="title" id="title" class="regular-text" value="<?php echo $title?>" />
			</td>
        </tr>
		
        <?php /*?><tr valign="top">
			<th scope="row">Description</th>
			<td><textarea name="description" id="description" class="large-text"><?php echo $description ?></textarea></td>
        </tr><?php */?>
		
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
	<input type="hidden" name="section" value="category" />
	<?php } else {?>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="section" value="category" />
	<?php } ?>
    <p class="submit">
    <input type="submit" name="submit_button" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php 
