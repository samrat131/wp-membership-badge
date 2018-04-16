<?php
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "membership_badge_category";
	$sql = "SELECT * FROM ".$table_name." WHERE 1 ORDER BY sortorder";
	$video_info = $wpdb->get_results($sql);
	?>
	<div class="wrap">
	<h2>Manage Badges</h2>
	
	<h4>For all category use <code>[badge]</code> shortcode </h4>
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
				<th class="manage-column column-title" scope="col">Title</th>
				<th class="manage-column column-title" scope="col">ShortCode</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<?php /*?><th class="manage-column column-title" scope="col" width="50">Delete</th><?php */?>
			</tr>
			</thead>
			
			<tbody>
			<?php foreach($video_info as $vdoinfo){ ?>
			<tr valign="top">
				<td>
					<?php echo $vdoinfo->title;?>
				</td>
				<td>
					[badge cid="<?php echo $vdoinfo->id;?>"]
				</td>
				<td>
					<?php echo $vdoinfo->sortorder;?>
				</td>
				<td>
					<a href="?page=mb_membership_badges_addcat&mode=edit&id=<?php echo $vdoinfo->id;?>"><strong>Edit</strong></a>
				</td>
				<?php /*?><td>
					<a onclick="show_confirm('<?php echo $vdoinfo->title?>','<?php echo $vdoinfo->id;?>');" href="#delete"><strong>Delete</strong></a>
				</td><?php */?>
				
			</tr>
			<?php }?>
			</tbody>
			<tfoot>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Title</th>
				<th class="manage-column column-title" scope="col">ShortCode</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<?php /*?><th class="manage-column column-title" scope="col" width="50">Delete</th><?php */?>
			</tr>
			</tfoot>
		</table>
	</div>
