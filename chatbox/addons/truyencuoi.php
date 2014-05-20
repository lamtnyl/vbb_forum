<?php
/*
Code Bot Shout Box Truyện cười  Ver 1.0
Code by BluE HearT - WwW.VnSoft4You.CoM - WwW.BluEHearT.OrG
Mail: webmaster@blueheart.org
Y!M: potaydotcomdotvn_blueheart
*/
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
//cuoi
$cuoi = spliti (" ",$shout['message'],2);
if(get_ascii($cuoi[0]) == "truyencuoi")
	{
		$maso = rand(100,999);
		$u = 'http://www.tuoitrecuoi.com/viet_index.php?loi='.$maso;
		$link=$u;
		$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, $header);   //trace header response
    curl_setopt($ch, CURLOPT_NOBODY, $header);  //return body
    curl_setopt($ch, CURLOPT_URL, $u);   //curl Targeted URL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_REFERER, $ref);   //fake referer
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    
        $kq = curl_exec($ch);
        curl_close($ch);
		
        preg_match('#<span class="joke_text">(.*)</span></font>#',$kq,$match);
		$ketqua = $match[0];
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b><br> " .$ketqua."";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}	
		?>