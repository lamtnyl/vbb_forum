<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');

$tmp = explode(" ",$shout['message']);
putenv("tz=asia/bangkok");


$h = date('G');
$m = date('i');
$today = date('d/m/Y');
$gio = $h.":".$m." phút - ".$today;
for($i=0 ; $i<20 ; ++$i)
{
	
if (get_ascii($tmp[$i]) == "may" &&  get_ascii($tmp[$i+1]) == "gio" ) 
		{		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> Bây giờ là " .$gio. " theo múi giờ GMT+7" ;
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}


}

############################# Danh Sach Bot ################################


if (preg_match('/^(hi|hello|helu|chào|xin chào|helo)$/si',$shout['message']) || preg_match('/^(hi|hello|helu|chào|xin chào)\s/si',$shout['message']))
	{
	$mess = array("đẹp chai","gay","xinh gái","les","pê đê");
	$zzzz = rand(0,3);
	$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> Chào <b>$shout[username]</b> " . $mess[$zzzz] . " nhé !";
	
	$handle = fopen($fcbfile['message'],"a");
			if ($config['remove_badword'])
			{
					$shout['message'] = remove_bad_word($shout['message']);
			}
			fwrite($handle, $shout['message']."\n");
			fclose($handle);
	}


elseif(preg_match('/(dâm|điên|dở hơi|hâm|khùng|thần kinh|đần độn|kìn|khìn|dở người|ngu si|dê|đê tiện|bot ngu|bot điên|chào bot ngu|chào bot điên|chào bot khùng|bựa|Bé Con điên)/si',$shout['message']) && preg_match('/(dâm|điên|dở hơi|hâm|khùng|thần kinh|đần độn|kìn|khìn|dở người|ngu si|dê|đê tiện|bot ngu|bot điên|chào bot ngu|chào bot điên|chào bot khùng|bựa|Bé Con điên)/si',$shout['message'],$bot))
	{$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> thấy <b>$shout[username]</b> còn $bot[1] hơn <img align='middle' src='http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/65.gif' />";
		$handle = fopen($fcbfile['message'],"a");
			if ($config['remove_badword'])
			{
					$shout['message'] = remove_bad_word($shout['message']);
			}
			fwrite($handle, $shout['message']."\n");
			fclose($handle);
}

elseif (preg_match('/^(be con|becon|Bé Con|Bé Con|$botname)$/si',$shout['message']) || preg_match('/^(becon|Bé Con|Bé Con|$botname)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> đang thắc mắc không biết sao $shout[username] lại nhắc tới bé. Yêu bé ko? <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/39.gif' />";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(xinh|xinh gái|đẹp trai|đẹp|handsome|ai đẹp|ai dep|ai đẹp|người đẹp|dep trai)/si',$shout['message']) || preg_match('/^(đẹp trai|đẹp|handsome|ai đẹp|ai dep|ai đẹp|người đẹp|dep trai)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b><font color='red'>$botname</font></b> nhủ thầm: $botname thấy anh <font color=red><b>hacobi</b></font> là đẹp trai nhất <b>Diễn Đàn THPTDaiMo.cc</b> <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/24.gif' />";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(hacobi1102|hacobi|hacobi|hacobi1102 khìn|nml|lmn|loi|anh hacobi1102|anh hacobi)$/si',$shout['message']) || preg_match('/^(hacobi1102|hacobi|hacobi|hacobi1102 khìn|ngô minh hacobi1102|nml|lmn|loi|anh hacobi1102|anh hacobi| anh hacobi)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> hỏi: $shout[username] gọi anh <font color=red><b>hacobi1102</b></font> có việc gì không? Bảo với $botname, $botname chuyển lời giúp cho <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/100.gif' />. Hi Hi! ";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/(ghét bé|ghet be|get bé|gét bé|gét be)/si',$shout['message']) || preg_match('/(ghét bé|ghet be|get bé|gét bé|gét be)/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > Sao $shout[username] lại gét <b>$botname</b> <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/14.gif' /> !";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/(yeu be|yêu bé|bé xinh|be xinh|bé giỏi|be gioi|bé thông minh|be thong minh|bé pro|be pro|bé thật pro|be that pro|bé that pro)/si',$shout['message']) || preg_match('/(yeu be|yêu bé|bé xinh|be xinh|bé giỏi|be gioi|bé thông minh|be thong minh|bé pro|be pro|bé thật pro|be that pro|bé that pro)/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > Hí hí <b>$botname</b> yêu $shout[username] lắm <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/8.gif' />!";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(chó|đỵt|địt|fuck|fuk|dyt|dit|lồn|lon|loz|vl|dkm|khùng)$/si',$shout['message']) || preg_match('/^(chó|đỵt|địt|fuck|fuk|dyt|dit|lồn|lon|loz|vl|dkm|khùng)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> nhắc nhở $shout[username]: Không chửi bậy, nói tục trên Shoutbox, hãy thể hiện mình là người lịch sự bạn nhé!";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(help|giúp|support|giup|vbb)$/si',$shout['message']) || preg_match('/^(help|giúp|support|giup|vbb)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> nhắc nhở $shout[username]: Cần hỏi gì thì lập topic để mọi người trả lời cho. Không hỏi đáp trên chatbox!";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(bye|chào|pipi|pp|bb|good bye|bibi|bi)$/si',$shout['message']) || preg_match('/^(bye|chào|pipi|pp|bb|good bye|bibi|bi)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> Bye $shout[username] nhé... Sớm quay trở lại Diễn Đàn <font color='red'><b>THPTĐạiMỗ.CC</b></font> với <b>$botname</b> và mọi người để chém gió tiếp nhé!!!";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif (preg_match('/^(tớ có|mình có|bot ai|tao có|đại ca|đại ka|bot anh|bot tao|bot đại ca)$/si',$shout['message']) || preg_match('/^(tớ có|mình có|bot ai|tao có|đại ca|đại ka|bot anh|bot tao|bot đại ca)\s/si',$shout['message']))
		{		$shout['message'] ="isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: Èm hèm! Để coi thái độ $shout[username] như thế nào với bé đã. Hehe";
		
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
elseif(!preg_match('/(daimo|dai mo|đạimỗ|đại mỗ)/si',$shout['message'])){
	if(preg_match('/(http\:|www\.|\.com|\.vn|\.net|\.biz|\.oni|\.cc|\.info)/si',$shout['message']))
	{$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> nhắc nhở <b>$shout[username]</b>: Không gửi link lên chatbox nhé bạn <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/33.gif' />";
	$handle = fopen($fcbfile['message'],"a");
			if ($config['remove_badword'])
			{
					$shout['message'] = remove_bad_word($shout['message']);
			}
			fwrite($handle, $shout['message']."\n");
			fclose($handle);
			}
}
elseif(preg_match('/(bé chào|be chao)/si',$shout['message']))
	{$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> chào <b>$shout[username]</b> hihi <img src='http://us.i1.yimg.com/us.yimg.com/i/mesg/emoticons7/59.gif' />";
	$handle = fopen($fcbfile['message'],"a");
			if ($config['remove_badword'])
			{
					$shout['message'] = remove_bad_word($shout['message']);
			}
			fwrite($handle, $shout['message']."\n");
			fclose($handle);
			}

?>