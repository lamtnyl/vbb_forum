<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
//avatar
$avatar = explode(" ",$shout['message']);
if (get_ascii($avatar[0] == "avatar"  ) )
		{		
				$anh = $avatar[1];
				$img = 'http://img.msg.yahoo.com/avatar.php?yids='.$anh;
				$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>:<b>Avatar của</b> <font color=blue><b>$anh</b></font> <b>đây nè</b>  <img src=".$img.">";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
?>