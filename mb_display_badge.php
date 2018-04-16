<?php
	global $wpdb, $msg;
	
	global $current_user;
	get_currentuserinfo();	
	
	$user_id = $current_user->ID;
	
	//print_r($atts);
	$where = " 1 ";
	$cid = $atts['cid'];
	//$where = " mbr.user_id=$user_id ";
	if($cid!='' and is_numeric($cid))
		$where = " mb.cat_id=$cid ";
		
	//if($user_id!='' and is_numeric($user_id))
		//$where .= " mb.cat_id=$cid and mbr.user_id=$user_id ";
	
	
	$mb_num_badge = get_option('mb-num-badge-count');
	$page_width = get_option('mb-badge-page-width');
	$mb_bgcolor = get_option('mb-bgcolor');
	$mb_padding = get_option('mb-padding');
	
	$image_file_path = get_option('siteurl')."/wp-content/uploads/";
	$table_name = $wpdb->prefix . "membership_badge";
	$table_name_cat = $wpdb->prefix . "membership_badge_category";
	$table_name_req = $wpdb->prefix . "membership_badge_request";
	//$sql = "SELECT mb.id as id, mb.image_url as image_url, mb.image_url2 as image_url2, mb.title as badge_name, mb.description as badge_desc,mb.description2 as badge_desc2, mb.sortorder as sortorder, mbc.title as cat_name FROM ".$table_name." mb inner join ".$table_name_cat." mbc on mb.cat_id=mbc.id WHERE $where ORDER BY sortorder";
	
	$sql = "SELECT mb.id as id, mb.image_url as image_url, mb.image_url2 as image_url2, mb.title as badge_name, mb.description as badge_desc,mb.description2 as badge_desc2, mb.sortorder as sortorder, mbc.title as cat_name, mbr.approve as approve  FROM ".$table_name." mb inner join ".$table_name_cat." mbc on mb.cat_id=mbc.id left join ".$table_name_req." mbr on mbr.badge_id=mb.id WHERE $where ORDER BY sortorder";
	//echo $sql; 
	$video_info = $wpdb->get_results($sql);
	//print_r($video_info);
	if(count($video_info)){
	?>
<style>
.badge-list table tr td{text-align:center !important; border:none !important;}
</style>	
<div class="badge-list" style=" max-width:<?php echo $page_width ?>px; background:<?php echo $mb_bgcolor ?>; padding:<?php echo $mb_padding ?>px;">

	<?php if($msg!='') echo '<h3 align="center">'.$msg.'</h3>' ?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php $i=0; foreach($video_info as $vdoinfo) { 
		$approve = $vdoinfo->approve;
		$class = '';
		if($approve == '')
			$class = 'thickbox';
		else
			$class = '';
			
		$image_url = '';
		if($approve != '' or $approve==0)	
			$image_url = $vdoinfo->image_url;
		if($approve == 1)	
			$image_url = $vdoinfo->image_url2;
			
		if($i++%$mb_num_badge == 0) echo '<tr id=tr-'.$i.'>';
	?>
	  
		<td><a href="#TB_inline?height=300&width=400&inlineId=badge_<?php echo $vdoinfo->id ?>" class="<?php echo $class ?>"><img src="<?php echo $image_file_path.$image_url;?>" border="0" width="150" height="" /></a><br /><?php echo $vdoinfo->badge_name;?><?php if($approve != '' and $approve != 1) echo ' | Request Pending' ?>
		
		<?php if($approve == '') { ?>
		<div id="badge_<?php echo $vdoinfo->id ?>" style="display:none;">
			<p><?php echo $vdoinfo->badge_desc ?></p>
			<hr />
			<form action="" method="post">
				<textarea name="user_request" style="width:97%; height:60px;"></textarea><br /><br />
				<input type="hidden" name="badge_id" value="<?php echo $vdoinfo->id ?>" />
				<input type="hidden" name="user_id" value="<?php echo $current_user->ID ?>" />
				<input type="submit" value="Submit" />
			</form>
		</div><?php } ?></td>
	  
	  
	<?php 
	if($i%$mb_num_badge == 0) echo '</tr>';
	//$i++ 
	} ?>
	</table>
	
	<?php } ?>
</div>