<?php
	
	global $wpdb;
	
	$image_file_path = "../wp-content/uploads/";
	$table_name = $wpdb->prefix . "membership_badge";
	$table_name_cat = $wpdb->prefix . "membership_badge_category";
	$sql = "SELECT mb.id as id, mb.image_url as image_url, mb.image_url2 as image_url2, mb.title as badge_name, mb.description as badge_desc,mb.description2 as badge_desc2, mb.sortorder as sortorder, mbc.title as cat_name FROM ".$table_name." mb inner join ".$table_name_cat." mbc on mb.cat_id=mbc.id WHERE 1 ORDER BY sortorder";
	//echo $sql; 
	$video_info = $wpdb->get_results($sql);
	//print_r($video_info);
	?>
	<div class="wrap">
	<h2>Manage Badges</h2>
	<script type="text/javascript">
	function show_confirm(title, id)
	{
		var rpath1 = "";
		var rpath2 = "";
		var r=confirm('Are you confirm to delete "'+title+'"');
		if (r==true)
		{
			rpath1 = '<?php echo $_SERVER['REQUEST_URI']; ?>';
			rpath2 = '&delete=y&id='+id;
			window.location = rpath1+rpath2;
		}
	}
	</script>
	
	
		<table class="widefat page fixed" cellspacing="0">
		
			<thead>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Badge Name</th>
				<th class="manage-column column-title" scope="col" width="100">Category</th>
				<th class="manage-column column-title" scope="col">Unaccomplished goals</th>
				<th class="manage-column column-title" scope="col">Accomplished goals</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Inactive</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Active</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<th class="manage-column column-title" scope="col" width="50">Delete</th>
			</tr>
			</thead>
			
			<tbody>
			<?php foreach($video_info as $vdoinfo){ ?>
			<tr valign="top">
				<td>
					<?php echo $vdoinfo->badge_name;?>
				</td>
				<td>
					<?php echo $vdoinfo->cat_name;?>
				</td>
				
				<td>
					<?php echo $vdoinfo->badge_desc; ?>
				</td>
				<td>
					<?php echo $vdoinfo->badge_desc2; ?>
				</td>
				
				<td>
					<img src="<?php echo $image_file_path.$vdoinfo->image_url;?>" border="0" width="100" height="" />
				</td>
				
				<td>
					<img src="<?php echo $image_file_path.$vdoinfo->image_url2;?>" border="0" width="100" height="" />
				</td>
	
				<td>
					<?php echo $vdoinfo->sortorder;?>
				</td>
				<td>
					<a href="?page=mb_membership_badges_addnew&mode=edit&id=<?php echo $vdoinfo->id;?>"><strong>Edit</strong></a>
				</td>
				<td>
					<a onclick="show_confirm('<?php echo $vdoinfo->badge_name?>','<?php echo $vdoinfo->id;?>');" href="#delete"><strong>Delete</strong></a>
				</td>
				
			</tr>
			<?php }?>
			</tbody>
			<tfoot>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Badge Name</th>
				<th class="manage-column column-title" scope="col" width="100">Category</th>
				<th class="manage-column column-title" scope="col">Unaccomplished goals</th>
				<th class="manage-column column-title" scope="col">Accomplished goals</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Inactive</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Active</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<th class="manage-column column-title" scope="col" width="50">Delete</th>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php  
