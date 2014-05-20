<? 
#####################################
# 	vBHome Version 3.0 Extended		#
# 	  Code by chiplove.9xpro	 	#		
# 	   Y!m: chiplove.9xpro			#
#		Update 12/9/2010		 	#
#####################################

define('IN_MEDIA', true);
define('THIS_SCRIPT', 'vbhome_index');
include('inc/config.php');
include('inc/functions.php');
include('inc/class_template.php');

$tpl_folder = 'template/' . $tpl_folder . '/';

$ajax_f = intval($_GET['ajax_f']);
$limit_list = ($_GET['limit']) ? intval($_GET['limit']) : 5;
//show ajax
if($ajax_f)
{
	$xtpl = new XTemplate($tpl_folder.template_ajaxbox);
	$array = array(
		'TARGET'	 => $target, 
		'LINK_BOX'	 => $forumdisplay.$ajax_f, 
	);
	$xtpl->assign($array);
	//Xu ly ID box (nhieu id)
	if(substr($_GET['ajax_f'], -1) == '*'){
		$chill = $db->query_first("SELECT childlist FROM " . TABLE_PREFIX . "forum WHERE  forumid = " . $ajax_f . "");
		$forumid_list = str_replace(',-1', '', $chill['childlist']);
	}
	else{
		$ex_last = explode(',', $_GET['ajax_f']);
		foreach($ex_last as $value){
			$forumid_list[] = intval($value);
		}
		$forumid_list = implode(', ', $forumid_list);
	}
	//Het Xu ly ID box (nhieu id)
	
	$tieudiem = $db->query_first("
		SELECT thread.title AS title, thread.threadid AS threadid, post.pagetext AS pagetext
		FROM " . TABLE_PREFIX . "thread  AS thread
		INNER JOIN " . TABLE_PREFIX . "post AS post ON (thread.firstpostid = post.postid AND post.parentid = 0)
		WHERE thread.visible = 1 AND thread.forumid IN (".$forumid_list.")
		ORDER BY thread.threadid DESC LIMIT 0, 1
	");
	if(!$tieudiem){
		$array = array(
			'TITLE'		 	 => 'Chưa có bài', 
			'TITLE_ASCII'	 => 'Chưa có bài', 
			'IMG'			 => 'img/no_img.gif', 
			'INTRO'			 => 'Box này trong forum chưa có bài'
		);
	}
	else{	
		$array = array(
			'TITLE'	 		=> m_emotions_replace($tieudiem['title']), 
			'TITLE_ASCII' 	=> htmlspecialchars($tieudiem['title']), 
			'IMG'		 	=> img_top_box($tieudiem['pagetext']), 
			'LINK'		 	=> $showthread.$tieudiem['threadid'], 
			'INTRO'		 	=> m_emotions_replace(intro_top_box($tieudiem['pagetext']))
		);
	}
	$xtpl->assign('TIEUDIEM', $array);
	$xtpl->parse('main.tieu_diem');
	////////////List bai moi /////////////
	$result = $db->query("
		SELECT title, views, threadid 
		FROM " . TABLE_PREFIX . "thread 
		WHERE visible = 1 AND forumid IN (".$forumid_list.")
		ORDER BY threadid DESC LIMIT 1, $limit_list
	");
	while($rows = $db->fetch_array($result)){
		$array = array(
			'TITLE_FULL'	=> $rows['title'], 
			'VIEWS'			=> $rows['views'], 
			'LINK'			=> $showthread.$rows['threadid'], 
			'TITLE'			=> fetch_trimmed_title($rows['title'], 40, true)
		);
		$xtpl->assign('LIST', $array);
		$xtpl->parse('main.list_bai_moi');
	}
	$xtpl->parse('main');
	$xtpl->out('main');
}
// het show ajax
///////////////////// Default index /////////////
else
{
	$xtpl = new XTemplate($tpl_folder.template_main);
	$rows = array(  
		'WEB_TITLE'		 => $web_title, 
		'KEYWORDS'		 => $keywords, 
		'DESCRIPTION'	 => $description, 
		'TARGET'		 => 'target="' . $target. '"', 
		'TPL_FOLDER'	 => $tpl_folder, 
		'VBHOME_VERSION' => VBHOME_VERSION, 
		'URL_FORUM'		 => $forum_url, 
		'LINK_BOX'		 => $forumdisplay, 
		'THONG_BAO'		 => $announcement, 
		'MUSIC_AUTO'	 => ($music_autoplay) ? 'true' : 'false',
	);

	
	/* ADS CODES */
	$result = $db->query("SELECT adid, code FROM ".VBHOME_PREFIX."ads ORDER BY adid");
	while($r = $db->fetch_array($result)){
		$rows['ADS_CODE'.$r['adid']] = stripslashes($r['code']);
	}	
	$xtpl->assign($rows);
	
	### BEGIN MAIN	
	$query = $db->query("SELECT link, title, img, intro FROM " . VBHOME_PREFIX . "main ORDER BY orderid");
	unset($array);
	$news_main = array();
	$i = 0;
	while($r_top = $db->fetch_array($query)){	
		$i++;
		$array[] = array(
			'LINK_'.$i	 		=> $r_top['link'], 
			'TITLE_'.$i	 		=> htmlspecialchars($r_top['title']), 
			'IMG_'.$i	 		=> check_img($r_top['img']), 
			'INTRO_'.$i	 		=> $r_top['intro'],
		);
	}
	foreach($array as $value){
		$news_main = array_merge($news_main, $value);
	}
	$xtpl->assign('TIN', $news_main);
	$xtpl->parse('main.tophot');
	###################### TOP HOT #########################

	for($loopbox = 0; $loopbox <= 1; $loopbox++)
	{
		if($loopbox == 0){$spot = 0; $parse_tpl = 'box_trai';}
		if($loopbox == 1){$spot = 1; $parse_tpl = 'box_phai';}
		
		$result_col = $db->query("
			SELECT name, id_box, limit_item, name_tcat 
			FROM " . VBHOME_PREFIX . "box 
			WHERE spot = " . $spot . " ORDER BY orderid ASC
		");
		$id_get_ajax = 0;
		while($r_col = $db->fetch_array($result_col))
		{
			$id_get_ajax++;
			$tcatbox = array('NAME' =>	$r_col['name_tcat']);
			$xtpl->assign('TCAT', $tcatbox);
	
			/* Xu ly tab box */
			$ex_namebox  = explode('|', $r_col['name']);
			$ex_idbox	 = explode('|', $r_col['id_box']);
			for($i = 0; $i < count($ex_namebox); $i++)
			{
				$box = array(
					'LINK'	 		=> $forumdisplay.intval($ex_idbox[0]), 
					'IDBOX'	 		=> $ex_idbox[$i].'&limit='.$r_col['limit_item'], 
					'NAME'	 		=> $ex_namebox[$i], 
					'ID_GET_AJAX' 	=> $id_get_ajax
				);
				$xtpl->assign('BOX', $box);
				$xtpl->parse('main.'.$parse_tpl.'.box_nho.tab_box_nho');
			}
			/* Het xu ly tab box */
			
			///////////////////////// TIEU DIEM //////////////////////////////////
			/* Xu ly noi dung box nhieu ID */
			unset($forumid_list);
			if(substr($ex_idbox[0], -1) == '*'){
				$chill = $db->query_first("
					SELECT childlist FROM " . TABLE_PREFIX . "forum 
					WHERE  forumid = " . intval($ex_idbox[0])."
				");								 
				$forumid_list = str_replace(',-1', '', $chill['childlist']);	
			}
			else{
				$ex_last = explode(',', $ex_idbox[0]);
				foreach($ex_last as $value){
					$forumid_list[] = intval($value);
				}
				$forumid_list = implode(', ', $forumid_list);
			}
			/* Het xu ly noi dung box nhieu ID */
			
			$tieudiem = $db->query_first("
				SELECT thread.title AS title, thread.threadid AS threadid, post.pagetext AS pagetext
				FROM " . TABLE_PREFIX . "thread  AS thread
				INNER JOIN " . TABLE_PREFIX . "post AS post ON (thread.firstpostid = post.postid AND post.parentid = 0)
				WHERE thread.visible = 1 AND thread.forumid IN (".$forumid_list.")
				ORDER BY thread.threadid DESC LIMIT 0, 1
			");
			unset($array);
			if(!$tieudiem){
				$array = array(
					'TITLE'	 		=> 'Chưa có bài', 
					'TITLE_ASCII' 	=> 'Chưa có bài', 
					'IMG'	 		=> 'img/no_img.gif', 
					'INTRO'	 		=> 'Box này trong forum chưa có bài'
				);
			}
			else{
				$array = array(
					'TITLE'	 		=> m_emotions_replace($tieudiem['title']), 
					'TITLE_ASCII' 	=> htmlspecialchars($tieudiem['title']), 
					'IMG'	 		=> img_top_box($tieudiem['pagetext']), 
					'LINK'	 		=> $showthread.$tieudiem['threadid'], 
					'INTRO'	 		=> m_emotions_replace(intro_top_box($tieudiem['pagetext']))
				);	
			}
			$xtpl->assign('TIEUDIEM', $array);
			$xtpl->parse('main.'.$parse_tpl.'.box_nho.tieu_diem');
			////////////List bai moi /////////////
			$list_read_more = $db->query("
				SELECT title, views, threadid 
				FROM " . TABLE_PREFIX . "thread 
				WHERE visible = 1 AND forumid IN (".$forumid_list.") 
				ORDER BY threadid DESC LIMIT 1, ".$r_col['limit_item']."
			");
			while($r_more = $db->fetch_array($list_read_more))
			{
				unset($array);
				$array = array(
					'TITLE_FULL'	=> $r_more['title'], 
					'VIEWS'		 	=> $r_more['views'], 
					'LINK'		 	=> $showthread.$r_more['threadid'], 
					'TITLE'		 	=> fetch_trimmed_title($r_more['title'], 40, true)
				);
				$xtpl->assign('LIST', $array);
				$xtpl->parse('main.'.$parse_tpl.'.box_nho.list_bai_moi');
			}
			$xtpl->parse('main.'.$parse_tpl.'.box_nho');
		}
		$xtpl->parse('main.'.$parse_tpl);
	}
	### END MAIN

	/* Link right */
	$query = $db->query("SELECT link, title FROM " . VBHOME_PREFIX . "rightpost ORDER BY id DESC");
	while($rows = $db->fetch_array($query)){
		$array = array(
			'LINK'	 => $rows['link'], 
			'TITLE'	 => fetch_trimmed_title(stripslashes($rows['title']), 50, true)
		);
		$xtpl->assign('RIGHT', $array);
		$xtpl->parse('main.link_right');
	}
	
	/* Link right random post */
	$query = $db->query("SELECT threadid, title, views FROM " . TABLE_PREFIX . "thread ORDER BY RAND() LIMIT 20");
	while($rows = $db->fetch_array($query)){
		$array = array(
			'LINK'	 => $showthread.$rows['threadid'], 
			'TITLE'	 => fetch_trimmed_title($rows['title'], 50, true), 
			'VIEWS'	 => $rows['views']
		);
		$xtpl->assign('RANDVIEW', $array);
		$xtpl->parse('main.randview');
	}
	/* Link right last post */
	$query = $db->query("SELECT threadid, title, views FROM " . TABLE_PREFIX . "thread ORDER BY threadid DESC LIMIT 20");
	while($rows = $db->fetch_array($query)){
		$array = array(
			'LINK'	 => $showthread.$rows['threadid'], 
			'TITLE'	 => fetch_trimmed_title(stripslashes($rows['title']), 50, true), 
			'VIEWS'	 => $rows['views']
		);
		$xtpl->assign('NEWPOST', $array);
		$xtpl->parse('main.newpost');
	}
	/* End link right last post */
	
	/* Check Login & Show info */
	$user = $db->query_first("
		SELECT user.userid, user.username, user.lastvisit, user.salt 
		FROM " . TABLE_PREFIX . "user AS user
		LEFT JOIN " . TABLE_PREFIX . "session AS session ON (session.userid  = user.userid)
		WHERE sessionhash = '" . addslashes($_COOKIE[COOKIE_PREFIX . 'sessionhash']) . "'
			OR sessionhash = '" . addslashes($_COOKIE[COOKIE_PREFIX . '_sessionhash']) . "'
		LIMIT 1	
	");
	if($user){
		$user['securitytoken_raw'] = sha1($user['userid'] . sha1($user['salt']) . sha1(COOKIE_SALT));
		$user['logouthash'] = time() . '-' . sha1(time() . $user['securitytoken_raw']);
		$array = array(
			'PROFILE_URL'	=> $forum_url . '/member.php?u=' . $user['userid'],
			'USERNAME'		=> $user['username'],
			'LASTVISIT'		=> date('h:i A', $user['lastvisit']),
			'LOGOUT_URL'	=> $forum_url . '/login.php?do=logout&logouthash=' . $user['logouthash'],
		);
		$xtpl->assign('USER', $array);
		$xtpl->parse('main.login_done');
	}
	else{
		$xtpl->parse('main.not_login');
	}
	/* Begin vBHome Plugin */
	
	/* Plugin Gallery */
	$pic_mem = 'pic_mem/';
	if(is_dir($pic_mem)){
		$d = dir($pic_mem);
		while(($f = $d->read()) != false){
			if(!in_array($f, array('.', '..')))
			$var['pic'][] = $pic_mem.$f;
			$var['url'][] = '#';
		}
		$gallery['LIST_PIC_MEM'] = implode('|', $var['pic']);
		$gallery['LIST_URL_MEM'] = implode('|', $var['url']);
	}
	unset($var);
	$pic_mem = 'pic_mem/Offline/';
	if(is_dir($pic_mem)){
		$d = dir($pic_mem);
		while(($f = $d->read())!= false){
			if(!in_array($f, array('.', '..')))
			$var['pic'][] = $pic_mem.$f;
			$var['url'][] = '#';
		}
		$gallery['LIST_PIC_OFF'] = implode('|', $var['pic']);
		$gallery['LIST_URL_OFF'] = implode('|', $var['url']);
	}
	$xtpl->assign($gallery);
	
	/* Begin Plugin Poll */
	$poll = $db->query_first("
		SELECT poll.*
		FROM ".TABLE_PREFIX."poll AS poll
		LEFT JOIN ".TABLE_PREFIX."thread AS thread ON (poll.pollid = thread.pollid)
		WHERE thread.threadid = ".$poll_threadid."	
		ORDER BY dateline DESC
		LIMIT 1
	");
	if($poll){
		$poll_options = explode('|||', $poll['options']);
		$poll_votes	  = explode('|||', $poll['votes']);
		$poll_count = 0;
		
		for($i = 0; $i < count($poll_votes); $i++){
			 $poll_count += $poll_votes[$i];
		}
		for($i = 0; $i < count($poll_options); $i++){
			$class = ($i+1) > 6 ? 1 : $i+1;
			$array = array(
				'NAME'		=> $poll_options[$i],
				'NUMBER'	=> $poll_votes[$i],
				'PERCENT'	=> (($poll_votes[$i]/$poll_count)*100),
				'CLASS'		=> $class,
			);
			$xtpl->assign('POLL', $array);
			$xtpl->parse('main.showpoll.poll_row');
		}
		$xtpl->assign('POLL', array('QUESTION' => removebbcode($poll['question'])) );
		$xtpl->parse('main.showpoll');
	}
	/* Begin Plugin Tag cloud */ 
	if($tagcloud){
		if(version_compare(FILE_VERSION, '4.0.0', '<')){
			$tag['tagthread'] = 'tagthread';
			$tag['threadid']  = 'threadid';
		}else{
			$tag['tagthread'] = 'tagcontent';
			$tag['threadid']  = 'contentid';
		}
		$result = $db->query("
			SELECT tag.tagid, tag.tagtext, COUNT(".$tag['tagthread'].".".$tag['threadid'].") AS count
			FROM ".TABLE_PREFIX."tag AS tag
			LEFT JOIN ".TABLE_PREFIX."".$tag['tagthread']." AS ".$tag['tagthread']."
				ON (tag.tagid = ".$tag['tagthread'].".tagid)	
			GROUP BY tag.tagid	
			LIMIT 20
		"); 
		
		while($row = $db->fetch_array($result)){
			$next_lv = 5;
			$class = ($row['count']/$next_lv) > 1 ? $row['count']/$next_lv : 1;
			$array = array(
				'TEXT'		=> $row['tagtext'],
				'COUNT'		=> $row['count'],
				'CLASS'		=> $class,
			);
			$xtpl->assign('TAG', $array);
			$xtpl->parse('main.tagcloud.tagbit');
		}
		$xtpl->parse('main.tagcloud');
	}
	
	$xtpl->parse('main');
	$xtpl->out('main');
}	
$db->close();
?>