<?php

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'vbhome_cpanel');
define('CSRF_PROTECTION', true);
define('CSRF_SKIP_LIST', '');

define('VBHOME_PREFIX', '1vbhome_');

require_once('./global.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

//only field post with mod
$mod_allow_do = array(
	'main_manage',
	'main_edit',
	'main_update',
	'rightpost_manage',
	'rightpost_edit',
	'rightpost_update'
);

if (!can_moderate(0, 'canbanusers') || !can_administer('canadminusers') && !in_array($_REQUEST['do'],$mod_allow_do))
{
	print_stop_message('no_permission');
}


#########################################################################################
############################# FUNCTION ADMIN VBHOMEX ####################################
#########################################################################################
function check_link_thread($str)
{
	 global $vbulletin;
	 if(preg_match("^showthread.php\?(p|t)=(\d{1,})(&title|#post?|.*)^",$str, $m))
	 {
		 if($m[1]=="p")
		 {
			 $threadid = $vbulletin->db->query_first("
				 SELECT threadid 
				 FROM " . TABLE_PREFIX . "post 
				 WHERE parentid = 0 AND postid = " . $m[2]
			 );
			if(!$threadid) return $str; 
			else return $vbulletin->options['bburl'] . '/showthread.php?t='.$threadid['threadid'];
		 }
		 elseif($m[1]=="t")
		 {
			  $threadid = $vbulletin->db->query_first("
				  SELECT threadid 
				  FROM " . TABLE_PREFIX . "thread 
				  WHERE threadid = " . $m[2]
			  );
			if(!$threadid) return $str;
			else return $vbulletin->options['bburl'] . '/showthread.php?t='.$threadid['threadid'];	
		 }
	}
	else
		return $str;
}
function check_img($url)
{
	if(!trim($url))
		return '../images/misc/unknown_sg.gif';
	elseif(!preg_match('#http://#i',$url))
		return 'http://i2.ytimg.com/vi/'.$url.'/default.jpg';
	else
		return $url;
}
#########################################################################################
############################# END FUNCTION ADMIN VBHOMEX ################################
#########################################################################################
print_cp_header('vBHome 3.0 Extended - chiplove.9xpro');


if($_REQUEST['do'] == 'ads_update')
{
	$code = $vbulletin->input->clean_gpc('p','code',TYPE_ARRAY_STR);
	$id = $vbulletin->input->clean_gpc('p','adid',TYPE_ARRAY_INT);
	$lap = count($id);
	for($i=0;$i<$lap;$i++)
	{
		$db->query_write("
			UPDATE " .VBHOME_PREFIX. "ads
			SET code  = '" . addslashes($code[$i]) . "'
			WHERE adid = " . $id[$i] . "
		");		
	}
	print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=ads_manage');	
}
if($_REQUEST['do'] == 'ads_manage')
{
	print_form_header('vbhome_cpanel', 'ads_update', false, true, '', '95%', '', false, 'post', 0);
	print_table_header("Quản lý quảng cáo",5);
	$rows = $db->query_read("SELECT * FROM " .VBHOME_PREFIX. "ads ORDER BY adid");		
	if($db->num_rows($rows))
	$i=0;
	while($row = $db->fetch_array($rows))
	{

		construct_hidden_code('adid[]', $row['adid']);
		print_textarea_row($row['name'], 'code[]', $row['code'],4,70);
		print_hidden_fields();	
		$i++;
	}
	
	print_submit_row('Save','Reset',2,'Back');
}

########################## QUANG CAO ##########################
if($_REQUEST['do'] == 'main_edit')
{
	print_form_header('vbhome_cpanel', 'main_update', false, true, '', '95%', '', false, 'post', 0);
	print_table_header("Quản lý bài top hot",5);
	construct_hidden_code('act', 'edit_main');
	print_hidden_fields();	
	$id_mod = $vbulletin->input->clean_gpc('r','id',TYPE_INT);
	construct_hidden_code('id', $id_mod);
	$item = $db->query_first("
			SELECT *
			FROM " .VBHOME_PREFIX. "main
			WHERE id = $id_mod
	");		
	print_input_row('Tiêu đề', 'title', $item['title'],true,50);
	echo'<tr valign="top">
		<td class="alt2">Hình ảnh</td>
		<td class="alt2"><img src="'. stripslashes(check_img($item['img'])).'" width="100" height="70"></td>
		</tr>';
	print_input_row('', 'img',  stripslashes($item['img']),true,50);
	print_input_row('Link bài viết', 'link',  stripslashes($item['link']),true,50);
	print_select_row('Thứ tự', 'orderid', array('1','2','3','4','5'), ($item['orderid']-1));
	print_textarea_row('Giới thiệu', 'intro',  stripslashes($item['intro']),10,50);
	print_submit_row('Save','Reset',2,'Back');
}
if($_REQUEST['do'] == 'main_update')
{
	if($_POST['act'] =='edit_main')
	{
		$vbulletin->input->clean_array_gpc('p', array(
			'id'          => TYPE_INT,
			'title'       => TYPE_STR,
			'link'    	  => TYPE_STR,
			'orderid'     => TYPE_INT,
			'intro'       => TYPE_STR,
			'img'    	  => TYPE_STR,
			));
		$db->query_write("
				UPDATE " .VBHOME_PREFIX. "main
				SET link  = '" . addslashes(check_link_thread($vbulletin->GPC['link'])) . "',
					orderid  = " . ($vbulletin->GPC['orderid']+1) . ",
					title  = '" . addslashes($vbulletin->GPC['title']) . "',
					intro  = '" . addslashes($vbulletin->GPC['intro']) . "',
					img  = '" . addslashes($vbulletin->GPC['img']) . "'
				WHERE id = " . $vbulletin->GPC['id']."
			");		
	}
	if($_POST['act'] =='update_orderid')
	{
		$idbox = $vbulletin->input->clean_gpc('p','id',TYPE_ARRAY_INT);
		$orderid_ = $vbulletin->input->clean_gpc('p','orderid',TYPE_ARRAY_INT);
		$lap=count($idbox);
		for($i=0;$i<=$lap;$i++)
		{
			$db->query_write("
				UPDATE " .VBHOME_PREFIX. "main
				SET orderid  = '" . $orderid_[$i] . "'
				WHERE id = '" . $idbox[$i] . "'
			");		
		}
	}
	print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=main_manage');	
}

if($_REQUEST['do'] == 'main_manage')
{
	print_form_header('vbhome_cpanel', 'main_update', false, true, '', '95%', '', false, 'post', 0);
	print_table_header("Quản lý bài top hot",5);
	construct_hidden_code('act', 'update_orderid');
	print_hidden_fields();	
	echo '<tr class="thead" valign="top" align="center">
			<td class="thead" width="3%">STT</td>
			<td class="thead" width="40%">Tiêu đề</td>
			<td class="thead" width="40%">Link</td>
			<td class="thead" width="15%">Hình ảnh</td>
			<td class="thead" width="3%">Sửa</td>
		</tr>';

		$rows = $db->query_read("
				SELECT id, orderid, title, link,img
				FROM " .VBHOME_PREFIX. "main
				ORDER BY orderid
				");	
		$i	= 1;
		if($db->num_rows($rows))
		while($row = $db->fetch_array($rows))
		{
			if($i%2==0) $class = 'alt2'; else $class = 'alt1';
			
			echo '<tr class="' . $class . '">
				<td class="smallfont" align="center"><input type="hidden" name="id[]" value="' . $row['id'] . '"><input value="' . $row['orderid'] . '" name="orderid[]" class="bginput" size="1"></td>
				<td class="smallfont"><b><a style="text-decoration:none" href="?do=main_edit&id=' . $row['id'] . '" title="Sửa">' .  stripslashes($row['title']) . '</b></a>
				<td class="smallfont" align="center"><input value="' .  stripslashes($row['link']) . '" class="bginput" size="48"></td>
				<td class="smallfont" align="center" width="100" height="70"><img src="' .  stripslashes(check_img($row['img'])) . '" width="100" height="70"></td>
				<td class="smallfont" align="center"><a href="?do=main_edit&id=' . $row['id'] . '" title="Sửa"><img alt="Sửa" src="../images/misc/userfield_edit.gif" border="0" hspace="6"></a></td>

			</tr>';	
			$i++;
		}
		else echo '<tr class="alt1"><td align="center" colspan="6">Chưa có box nào!</td></tr>';
		$db->free_result($items);
	print_submit_row('Sửa thứ tự', '', 5, '', '', false);
	print_cp_footer();
}
########################## BOX ##########################
if($_REQUEST['do'] == 'box_edit')
{
	if($_REQUEST['act'] == 'del')
	{
		$id_mod = $vbulletin->input->clean_gpc('r','id',TYPE_INT);
		if($id_mod)
		{
			$db->query_write("DELETE FROM " .VBHOME_PREFIX. "box WHERE id = " . $id_mod);
			print_cp_message  ($db->affected_rows().' box vừa bị xóa', 'vbhome_cpanel.php?do=box_manage');
		}
		else print_cp_message("Bạn chưa chọn box nào");
		print_cp_footer();
	}
	else
	{
		print_form_header('vbhome_cpanel', 'box_update', false, true, '', '90%', '', false, 'post', 0);
		if($_REQUEST['act'] == 'add')
		{
			print_table_header('Thêm box',5);
			construct_hidden_code('act', 'add_box');
			print_hidden_fields();				
		}
		if($_REQUEST['id'])
		{
			print_table_header('Sửa box',5);
			construct_hidden_code('act', 'edit_box');
			construct_hidden_code('id', $vbulletin->input->clean_gpc('r','id',TYPE_INT));
			print_hidden_fields();	
			$id_mod = $vbulletin->input->clean_gpc('r','id',TYPE_INT);
			$item = $db->query_first("
					SELECT *
					FROM " .VBHOME_PREFIX. "box
					WHERE id = $id_mod
			");					
		}
			
		$limit = (!$item['limit_item'])?5:$item['limit_item'];
		print_input_row('Tên box<br><dfn>Box1|Box2|Box3</dfn>', 'name', $item['name'],true,50);
		print_input_row('ID box<br><dfn>1*|2,4,5|3', 'id_box', $item['id_box'],true,50);
		print_input_row('Thứ tự', 'orderid', $item['orderid'],true,50);
		print_input_row('List bài mới', 'limit_item', $limit,true,50);
		print_radio_row('Hiển thị', 'spot', array('Bên trái','Bên phải'), $item['spot']);
		print_input_row('Name t_cat<br><dfn>tcat_kutegirl</dfn>', 't_cat', $item['name_tcat'],true,50);
		print_submit_row('Save','Reset',2,'Back');		
	}
}

if($_REQUEST['do'] == 'box_update')
{
	if($vbulletin->input->clean_gpc('p','act',TYPE_STR)!='update_orderid')
	{

		$vbulletin->input->clean_array_gpc('p', array(
			'id'          	=> TYPE_INT,
			'name'      	=> TYPE_STR,
			'id_box'      	=> TYPE_STR,
			'orderid'      	=> TYPE_INT,
			'limit_item'    => TYPE_INT,
			'spot'     		=> TYPE_INT,
			't_cat'      	=> TYPE_STR,
		));

		if($_POST['act'] =='add_box')
		{
			$db->query_write("
					INSERT INTO  " .VBHOME_PREFIX. "box (id_box,name,orderid,limit_item,spot,name_tcat)
					VALUE ('" .  $vbulletin->GPC['id_box'] . "','" .  addslashes($vbulletin->GPC['name']) . "',
							" .  $vbulletin->GPC['orderid'] . "," .  $vbulletin->GPC['limit_item'] . ",
							" .  $vbulletin->GPC['spot'] . ",	'" .  addslashes($vbulletin->GPC['t_cat']) . "')
			");		
			print_cp_message('Đã thêm xong', 'vbhome_cpanel.php?do=box_manage');	
		}
		if($_POST['act'] =='edit_box')
		{
			$db->query_write("
					UPDATE " .VBHOME_PREFIX. "box
					SET id_box  = '" .  $vbulletin->GPC['id_box'] . "',
						name = '" . addslashes($vbulletin->GPC['name']) . "',
						orderid = " .  $vbulletin->GPC['orderid'] . ",
						limit_item = " .  $vbulletin->GPC['limit_item'] . ",
						spot = " .  $vbulletin->GPC['spot'] . ",
						name_tcat = '" .  addslashes($vbulletin->GPC['t_cat']) . "'
					WHERE id = " .  $vbulletin->GPC['id'] . "
			");		
			print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=box_manage');	
		}
	}
	if($_POST['act'] =='update_orderid')
	{
		$idbox = $vbulletin->input->clean_gpc('p','id',TYPE_ARRAY_INT);
		$orderid_ = $vbulletin->input->clean_gpc('p','orderid',TYPE_ARRAY_INT);
		$lap=count($idbox);
		for($i=0;$i<=$lap;$i++)
		{
			$db->query_write("
				UPDATE " .VBHOME_PREFIX. "box
				SET orderid  = '" . $orderid_[$i] . "'
				WHERE id = '" . $idbox[$i] . "'
			");		
		}
		print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=box_manage');	
	}

	
}
if($_REQUEST['do'] == 'box_manage')
{
	print_form_header('vbhome_cpanel', 'box_update', false, true, '', '90%', '', false, 'post', 0);
	print_table_header("Quản lý | <a href='?do=box_edit&act=add'>Thêm box</a>",5);
	construct_hidden_code('act', 'update_orderid');
	print_hidden_fields();	
	echo '<tr valign="top" align="center">
			<td class="thead" width="3%">STT</td>
			<td class="thead" width="50%">Tên box</td>
			<td class="thead" width="8%">Hiển thị</td>
			<td class="thead" width="3%">Sửa</td>
			<td class="thead" width="3%">Xóa</td>
		</tr>';
		
	$spots = array(
		0 	=> 'Bên trái',
		1	=> 'Bên phải',
	//	2	=> 'Bên trái 2',
	//	3	=> 'Bên phải 2'
	);	
	for($j=0;$j<=1;$j++)
	{
		$spot = $spots[$j];
		if($j > 0)
		echo '<tr class="thead" valign="top" align="center">
			<td colspan="5">&nbsp;</td>
		</tr>';
		
		$rows = $db->query_read("
				SELECT id,name,orderid
				FROM " .VBHOME_PREFIX. "box
				WHERE spot = " . $j . "
				ORDER BY orderid
				");	
		$i	= 1;
		if($db->num_rows($rows))
		while($row = $db->fetch_array($rows))
		{

			$class = ($i%2==0)?'alt2':'alt1';
			echo '<tr class="' . $class . '">
				<td class="smallfont" align="center"><input type="hidden" name="id[]" value="' . $row['id'] . '"><input value="' . $row['orderid'] . '" name="orderid[]" class="bginput" size="1"></td>
				<td class="smallfont" align="center"><b><a style="text-decoration:none" href="?do=box_edit&id=' . $row['id'] . '" title="Sửa">' .  stripslashes($row['name']) . '</b></a></td>
				<td class="smallfont" align="center">'.$spot.'</td>
				<td class="smallfont" align="center"><a href="?do=box_edit&id=' . $row['id'] . '" title="Sửa"><img alt="Sửa" src="../images/misc/userfield_edit.gif" border="0" hspace="6"></a></td>
				<td class="smallfont" align="center"><a onclick="return confirm(\'Bạn có muốn xóa box này ko?\');" href="?do=box_edit&act=del&id=' . $row['id'] . '" title="Xóa"><img alt="Xóa" src="../images/misc/colorpicker_close.gif" border="0" hspace="6"></a></td>
			</tr>';	
			$i++;
		}
		else echo '<tr class="alt1"><td align="center" colspan="6">'.$spot.' - Chưa có box nào!</td></tr>';
		$db->free_result($items);
	}
	print_submit_row('Sửa thứ tự', '', 6, '', '', false);
	print_cp_footer();
}
########################## MUSIC LIST ##########################

if($_REQUEST['do'] == 'music_list')
{
	$result = $db->query_read("
		SELECT name, value FROM " . VBHOME_PREFIX . "config 
		WHERE name IN ('music_list','music_autoplay')
	");
	while($r = $db->fetch_array($result)){
		$$r['name'] = stripslashes($r['value']);
	}
	
	print_form_header('vbhome_cpanel', 'vbhome_config_update', false, true, '', '90%', '', false, 'post', 0);
	print_table_header("List nhạc nền",2);
	print_yes_no_row('<b>Chế độ play tự động</b>', 'music_autoplay', $music_autoplay);
	print_textarea_row('<b>List nhạc nền</b><br><dfn>Nhập đúng cấu trúc nếu ko sẽ bị lỗi<br></dfn>
<br><dfn>[Track]<br>
[Title]<strong>Ca sĩ</strong>[/Title]<br>
[Song]<strong>Bài hát</strong>[/Song] <br>
[Link]<strong>Link</strong>[/Link]<br>
[DL]<strong>Link download</strong>[/DL]<br>
[/Track]</dfn>', 'music_list',  $music_list,20,70);
	print_submit_row('Save','Reset',2,'Back');	
	print_cp_footer();
}

########################## VBHOMEX CONFIG ##########################
if($_REQUEST['do'] == 'vbhome_config')
{
	$result = $db->query_read("SELECT name, value FROM " . VBHOME_PREFIX . "config");
	while($r = $db->fetch_array($result)){
		$$r['name'] = stripslashes($r['value']);
	}
	
	print_form_header('vbhome_cpanel', 'vbhome_config_update', false, true, 'config', '90%', '', false, 'post', 0);
	print_table_header("Cấu hình web | <a href='?do=music_list'>List nhạc nền</a>",2);
	print_input_row('Tiêu đề web', 'web_title',  $web_title,true,50);
	print_input_row('Từ khóa', 'keywords',  $keywords,true,50);
	print_input_row('Folder giao diện', 'tpl_folder',  $tpl_folder,true,50);
	print_select_row('Target', 'target', array('_blank' => '_blank','_self' => '_self'), $target);
	print_input_row('Show poll of threadid', 'poll_threadid',  $poll_threadid, true,50);
	print_yes_no_row('Show tag cloud', 'tagcloud',  $tagcloud);
	print_input_row('Mod đăng tin', 'vbhome_mod',  $vbhome_mod,true,50);
	print_textarea_row('Thông báo', 'announcement', $announcement ,10,70);
	print_submit_row('Save','Reset',2,'Back');	
	print_cp_footer();
}
if($_REQUEST['do'] == 'vbhome_config_update')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'web_title'        	=> TYPE_STR,
		'keywords'        	=> TYPE_STR,
		'target'           	=> TYPE_STR,
		'tpl_folder'      	=> TYPE_STR,
		'vbhome_mod'      	=> TYPE_STR,
		'poll_threadid'		=> TYPE_INT,
		'announcement'    	=> TYPE_STR,
		'music_autoplay'	=> TYPE_INT,
		'music_list'		=> TYPE_STR,
		'tagcloud'			=> TYPE_BOOL,
	));
		
	if($vbulletin->GPC['web_title'])
	{	
		$array = array('poll_threadid','web_title','keywords','target','tpl_folder','vbhome_mod','announcement','tagcloud');	
		foreach($array as $value){
			$db->query_write("
				UPDATE " .VBHOME_PREFIX. "config
				SET value  =  '" . addslashes($vbulletin->GPC[$value]) . "' 
				WHERE name = '".$value."'
			");	
		}
		print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=vbhome_config');	
	}
	if($vbulletin->GPC['music_list'])
	{
		$array = array('music_list','music_autoplay');	
		foreach($array as $value){
			$db->query_write("
				UPDATE " .VBHOME_PREFIX. "config
				SET value  =  '" . addslashes($vbulletin->GPC[$value]) . "' 
				WHERE name = '".$value."'
			");	
		}

		print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=music_list');	
	}
	
}

########################## RIGHT POST ##########################
if($_REQUEST['do'] == 'rightpost_manage')
{
	print_form_header('vbhome_cpanel', 'rightpost_delete', false, true, '', '90%', '', false, 'post', 0);
	print_table_header("Quản lý | <a href='?do=rightpost_edit&act=add'>Thêm bài</a>",4);

	echo '<tr class="thead" valign="top" align="center">
			<td width="46%">Tiêu đề bài viết</td>
			<td width="46%">Link bài viết</td>
			<td width="4%">Sửa</td>
			<td width="4%"><input type="checkbox" id="allbox" onclick="return js_check_all(this.form)"></td>
		</tr>';
	$rows = $db->query_read("
			SELECT id,title,link
			FROM " .VBHOME_PREFIX. "rightpost
			ORDER BY id DESC
			");	
	$i	= 1;
	if($db->num_rows($rows))
	while($row = $db->fetch_array($rows))
	{
		if($i%2==0) $class = 'alt2'; else $class = 'alt1';
		echo '<tr class="' . $class . '">
			<td class="smallfont"><b>' . stripslashes($row['title']) . '</b></td>
			<td class="smallfont"><input class="bginput" style="width:100%" type="text" value="'.  stripslashes($row['link']) .'"> </td>
			<td class="smallfont" align="center"><a href="?do=rightpost_edit&id=' . $row['id'] . '" title="Edit"><img title="Edit" alt="Edit" src="../images/misc/userfield_edit.gif" border="0" hspace="6"></a></td>
			<td class="smallfont" align="center"><input name="rightpostid[]" type="checkbox" value="'.$row['id'].'"></td>
		</tr>';	
		$i++;
	}
	else echo '<tr class="alt1"><td align="center" colspan="6">Chưa có bài nào!</td></tr>';
	$db->free_result($items);
	print_submit_row('Delete" onclick="return confirm(\'Bạn có muốn xóa những bài này ko?\')', 'Reset', 6, '', '', false);
	print_cp_footer();
}

if($_REQUEST['do'] == 'rightpost_edit')
{
	print_form_header('vbhome_cpanel', 'rightpost_update');
	if($_REQUEST['act']=='add')
	{
		construct_hidden_code('act', 'add');
		print_hidden_fields();	
		print_table_header('Thêm bài viết');
		
	}
	else
	{
		$id_mod = $vbulletin->input->clean_gpc('r','id',TYPE_INT);
		$item = $db->query_first("
				SELECT title,link
				FROM " .VBHOME_PREFIX. "rightpost
				WHERE id = $id_mod
		");		
		print_table_header('Sửa bài viết');
	}
	construct_hidden_code('id', $id_mod);
	print_hidden_fields();		
	print_input_row('Tiêu đề bài', 'title', $item['title'],true,50);
	print_input_row('Link bài', 'link', $item['link'],true,50);
	print_submit_row('Save','Reset',2,'Back');		
}

if($_REQUEST['do'] == 'rightpost_update')
{
	$title = $vbulletin->input->clean_gpc('r','title',TYPE_STR);
	$link = $vbulletin->input->clean_gpc('r','link',TYPE_STR);
	
	if($vbulletin->input->clean_gpc('r','act',TYPE_STR)){
		$item = $db->query_write("
				INSERT INTO  " .VBHOME_PREFIX. "rightpost (title,link)
				VALUE ('" . addslashes($title) . "','" . addslashes(check_link_thread($link)) . "')
		");		
		print_cp_message('Đã thêm xong', 'vbhome_cpanel.php?do=rightpost_manage');	
	}
	else{
		$id_mod = $vbulletin->input->clean_gpc('p','id',TYPE_INT);
		$item = $db->query_write("
				UPDATE " .VBHOME_PREFIX. "rightpost
				SET title = '" . addslashes($title) . "',
					link = '" . addslashes(check_link_thread($link)) . "'
				WHERE id = $id_mod
		");	
		print_cp_message('Đã sửa xong', 'vbhome_cpanel.php?do=rightpost_manage');	
	}
}


if($_REQUEST['do'] == 'rightpost_delete')
{
	$id_mod = $vbulletin->input->clean_gpc('p','rightpostid',TYPE_ARRAY_INT);
	if($id_mod)
	{
		$db->query_write("DELETE FROM " .VBHOME_PREFIX. "rightpost WHERE id IN (" . implode(',',$id_mod) . ")");
		print_cp_message  ($db->affected_rows().' bài vừa bị xóa', 'vbhome_cpanel.php?do=rightpost_manage');
	}
	else print_cp_message("Bạn chưa chọn bài nào");
	print_cp_footer();
}


?>