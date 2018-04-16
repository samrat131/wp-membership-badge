<?php
	global $wpdb;
	
	$image_file_path = "../wp-content/uploads/";
	
	$table_name = $wpdb->prefix . "membership_badge";
	$table_name_cat = $wpdb->prefix . "membership_badge_category";
	$table_name_req = $wpdb->prefix . "membership_badge_request";
	
	
	//$sql = "SELECT mb.id as id, mb.image_url as image_url, mb.image_url2 as image_url2, mb.title as badge_name, mb.description as badge_desc,mb.description2 as badge_desc2, mb.sortorder as sortorder, mbc.title as cat_name FROM ".$table_name." mb inner join ".$table_name_cat." mbc on mb.cat_id=mbc.id WHERE 1 ORDER BY sortorder";
	
	$sql = "SELECT mb.id as id, mb.image_url as image_url, mb.image_url2 as image_url2, mb.title as badge_name, mb.description as badge_desc,mb.description2 as badge_desc2, mb.sortorder as sortorder, mbc.title as cat_name, mbr.approve as approve, mbr.user_id as user_id, mbr.user_request as user_request FROM ".$table_name." mb inner join ".$table_name_cat." mbc on mb.cat_id=mbc.id inner join ".$table_name_req." mbr on mbr.badge_id=mb.id WHERE 1 ORDER BY sortorder";
	//echo $sql; 
	$video_info = $wpdb->get_results($sql);
	//print_r($video_info);
	?>
	<script type="text/javascript">
	function show_confirm(title, id, mode)
	{
		var rpath1 = "";
		var rpath2 = "";
		var r=confirm('Are you confirm to '+mode+' "'+title+'"');
		if (r==true)
		{
			rpath1 = '<?php echo $_SERVER['REQUEST_URI']; ?>';
			rpath2 = '&'+mode+'=y&id='+id;
			//alert(rpath1+rpath2);
			window.location = rpath1+rpath2;
		}
	}
	</script>
	
	<div class="wrap">
	<h2>Review Badges</h2>
	
		<table class="widefat page fixed" cellspacing="0">
		
			<thead>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Badge Name</th>
				<th class="manage-column column-title" scope="col" width="100">Category</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Image</th>
				<th class="manage-column column-title" scope="col" width="50">User</th>
				<th class="manage-column column-title" scope="col">User Request</th>
				<th class="manage-column column-title" scope="col" width="55">Status</th>
				<th class="manage-column column-title" scope="col" width="100">Action</th>
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
					<img src="<?php echo $image_file_path.$vdoinfo->image_url2;?>" border="0" width="100" height="" />
				</td>
	
				<td>
					<?php 
					$user_info = get_userdata($vdoinfo->user_id);
				    echo $user_info->user_login;
					?>
				</td>
				<td>
					<?php echo $vdoinfo->user_request;?>
				</td>
				
				<td>
					<?php echo $vdoinfo->approve==1?'Approved':'Pending';?>
				</td>
				<td>
					<a onclick="show_confirm('<?php echo $vdoinfo->badge_name?>','<?php echo $vdoinfo->id;?>','approve');" href="#approve"><strong>Approve</strong></a> | <a onclick="show_confirm('<?php echo $vdoinfo->badge_name?>','<?php echo $vdoinfo->id;?>','deny');" href="#deny"><strong>Deny</strong></a>
				</td>
				
			</tr>
			<?php }?>
			</tbody>
			<tfoot>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Badge Name</th>
				<th class="manage-column column-title" scope="col" width="100">Category</th>
				<th class="manage-column column-title" scope="col" width="100">Badge Image</th>
				<th class="manage-column column-title" scope="col" width="50">User</th>
				<th class="manage-column column-title" scope="col">User Request</th>
				<th class="manage-column column-title" scope="col" width="55">Status</th>
				<th class="manage-column column-title" scope="col" width="100">Action</th>
			</tr>
			</tfoot>
		</table>
	</div>