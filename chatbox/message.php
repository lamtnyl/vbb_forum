﻿<?php
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

##### POST SHOUT #######
if ($_REQUEST['do'] == 'postshout')
{
	$managegroup = explode(",", $config['managegroup']);
	$shout = $_REQUEST;
	
	if ($config['check_domain_reffer'] AND !checkpost($config['forumlink'] , $_SERVER['HTTP_REFERER']))
	{
		echo $phrase['accessdenied'];
		exit;
	}
	
	$request_ip = $_SERVER['REMOTE_ADDR'];
	
	if ($config['strip_slash'])
	{
		$shout['username'] = stripslashes($shout['username']);
		$shout['message'] = stripslashes($shout['message']);
	}
	
	if ($config['check_chatbox_key'] AND !check_chatbox_key($shout['key'], $shout['userid'], $shout['username'], $shout['groupid']))
	{
		echo $phrase['accessdenied'];
		exit;
	}
	
	$banneds = unserialize(file_get_contents($fcbfile['ds_banned']));

	$cancommand = false;
	if (in_array($shout['groupid'], $managegroup))
	{
		$cancommand = true;
	}
	
	if ($shout['message'] && $shout['userid'])
	{
		// CHECK BANNED USER
		if (isset($banneds[$shout['userid']]))
		{
			echo $phrase['bannotice'];
			exit;
		}
		
		// Cut message
		if (strlen($shout['message']) > $config['max_message_len']) $shout['message'] = substr($shout['message'], 0, $config['max_message_len']).'...';
			
		$shout['userid'] = intval($shout['userid']);
		$shout['groupid'] = intval($shout['groupid']);
		$shout['color'] = strip_tags($shout['color']);
		$shout['font'] = strip_tags($shout['font']);
		
		$shout['dateline'] = time();
		
		$checknoticecm = substr($shout['message'], 0, strlen($command['notice'])+1);
		$checkbancm = substr($shout['message'], 0, strlen($command['ban'])+1);
		$checkunbancm = substr($shout['message'], 0, strlen($command['unban'])+1);
		$checkpruneuser = substr($shout['message'], 0, strlen($command['prune'])+1);

		$type = '';
		if ($shout['message'] == $command['prune'] AND $cancommand)
		{
			$type = 'prune1';
		}
		else if ($checkpruneuser == $command['prune'].' ' AND $cancommand)
		{
			$type = 'prune2';
		}
		else if ($shout['message'] == $command['notice'] AND $cancommand)
		{
			$type = 'notice1';
		}
		else if ($checknoticecm == $command['notice'].' ' AND $cancommand)
		{
			$type = 'notice2';
		}
		else if ($checkbancm == $command['ban'].' ' AND $cancommand)
		{
			$type = 'ban';
		}
		else if ($checkunbancm == $command['unban'].' ' AND $cancommand)
		{
			$type = 'unban';
		}
		else
		{
			$type = 'chat';
		}
		$shout['type'] = $type;
			
		switch ($type)
		{
			case 'prune1':
				$handle = fopen($fcbfile['message'],"w");
				fwrite($handle, build_prune1($shout)."\n");
				fclose($handle);
				break;
					
			case 'prune2':
				$info = explode(" ", $shout['message']);
				$shout['pruneuserid'] = intval($info[1]);
				$shout['reason'] = substr($shout['message'], strlen($command['prune'].' '.$info[1])+1);
				$shout['pruneusername'] = findusername($shout['pruneuserid']);
				if ($shout['pruneusername'])
				{
					$shouts = file($fcbfile['message']);
					$handle = fopen($fcbfile['message'],"w");
					foreach ($shouts as $shoutline)
					{
						$shoutf = split_shoutline($shoutline);
						if ($shoutf['userid'] != $shout['pruneuserid'] OR ($shoutf['type'] != 'chat' AND $shoutf['type'] != 'isme'))
						{
							fwrite($handle, $shoutline);
						}
					}
					fwrite($handle, build_prune2($shout)."\n");
					fclose($handle);
				}
				else
				{
					echo $phrase['nomessagefound']."<br />";
				}
				break;
					
			case 'notice1':
					$handle = fopen($fcbfile['notice'],"w");
					fclose($handle);
					build_notice();
					break;
					
			case 'notice2':
					$smilies = unserialize(file_get_contents($fcbfile['ds_smilie']));
					$handle = fopen($fcbfile['notice'],"w");
					$noticemess = substr($shout['message'], strlen($command['notice'])+1);
					fwrite($handle, $noticemess);
					fclose($handle);
					build_notice();
					break;
					
			case 'ban':
					$banneds = unserialize(file_get_contents($fcbfile['ds_banned']));
					$info = explode(" ", $shout['message']);
					$shout['banuserid'] = intval($info[1]);
					$shout['banusername'] = findusername($shout['banuserid']);
					$shout['reason'] = substr($shout['message'], strlen($command['ban'].' '.$info[1])+1);
					$banneds[$shout['banuserid']] = $shout['reason'];
					$handle = fopen($fcbfile['ds_banned'], "w");
					fwrite($handle, serialize($banneds));
					fclose($handle);
					
					$handle = fopen($fcbfile['message'],"a");
					fwrite($handle, build_ban($shout)."\n");
					fclose($handle);
					break;
				
			case 'unban':
					$banneds = unserialize(file_get_contents($fcbfile['ds_banned']));
					$info = explode(" ", $shout['message']);
					$shout['unbanuserid'] = intval($info[1]);
					$shout['unbanusername'] = findusername($shout['unbanuserid']);
					$shout['reason'] = substr($shout['message'], strlen($command['unban'].' '.$info[1])+1);
					unset($banneds[$shout['unbanuserid']]);
					$handle = fopen($fcbfile['ds_banned'], "w");
					fwrite($handle, serialize($banneds));
					fclose($handle);
					
					$handle = fopen($fcbfile['message'],"a");
					fwrite($handle, build_unban($shout)."\n");
					fclose($handle);
					break;
				
			case 'chat':
					if ($config['checkflood'] AND is_flood($request_ip, $shout['message']))
					{
						echo "<div>".$phrase['checkflood']."</div>";
						exit;
					}
					if ($config['checkflood'])
					{
						// save last shout
						$handle = fopen($fcbfile['ds_lastshout'],"w");
						$ls['ip'] = $request_ip;
						$ls['message'] = $shout['message'];
						$data = serialize($ls);
						fwrite($handle, $data);
						fclose($handle);
					}
					$smilies = unserialize(file_get_contents($fcbfile['ds_smilie']));
					// save chat message
					$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, build_chat($shout)."\n");
					fclose($handle);
			}
	}
}

############################# Bot Mr.Km ################################
require_once('addons/bot.php');
require_once('addons/thoitiet.php');
require_once('addons/help.php');
require_once('addons/tudien.php');
require_once('addons/boitinhyeu.php');
require_once('addons/checkym.php');
require_once('addons/thayphan.php');
require_once('addons/truyencuoi.php');
require_once('addons/avatar.php');
require_once('addons/xoso.php');
require_once('addons/ngoaite.php');
############################# Ket Thuc Danh Sach Messenger AS ################################
		
function get_ascii($str) {
	$chars = array(
	'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e' 	=>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('đ','Đ'),
	'b'	=>	array('B'),	
	'n'	=>	array('N'),	
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}	


############################# SHOW MESSAGE ################################
	if ($config['new_at_bottom'])
	{
		$shouts = file($fcbfile['message']);
		$messsl = sizeof($shouts);
		$start = $messsl - $config['maxmessage'];
		if ($start < 0) $start = 0;
		$shouts = array_slice($shouts, $start);
		
		foreach ($shouts as $shout)
		{
			$sbox = trim($shout);
			echo '<div style="margin: 3px 0px 3px 0px;">'.build_message($shout).'</div>';
		}
		$notice = file_get_contents($fcbfile['ds_notice']);
		if ($notice)
		echo '<hr size="1" style="color:#D1D1E1; background-color:#D1D1E1" />'.$phrase['notice'].$notice;
	}
	else
	{
		$notice = file_get_contents($fcbfile['ds_notice']);
		if ($notice)
		echo $phrase['notice'],$notice,'<hr size="1" style="color:#D1D1E1; background-color:#D1D1E1" />';
	
		$shouts = file($fcbfile['message']);
		krsort($shouts);
		$count = 0;
		foreach ($shouts as $shout)
		{
			++$count;
			$shout = trim($shout);
			echo '<div style="margin: 3px 0px 3px 0px;">'.build_message($shout).'</div>';
			if ($count == $config['maxmessage']) break;
		}
	}
?>