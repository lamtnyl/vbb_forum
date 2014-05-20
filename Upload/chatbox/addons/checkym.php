

<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');

//check nick 

$nick = spliti (" ",$shout['message'],2);
if(get_ascii($nick[0]) == "check") 
	{
		$yid = $nick[1];
		$ref='http://www.yahoostatus.ro/';
		$post='id='.$yid.'&amp;submit=Check';
		$kq = cURL("http://www.yahoostatus.ro/check-status.php?",$ref,0,0,$post);
		preg_match('#<b><u>(.*)</b></u>#', $kq, $match);
		$kq = $match[0];  
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>:Nick  <b><font color=green>" .$nick[1]."</font></b> hiện tại đang <b><font color=red>".$kq."</font></b>";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}		
function cURL($url, $ref, $header, $cookie, $p)
{
    $ch = curl_init();//start curl<br>
    curl_setopt($ch, CURLOPT_HEADER, $header);   //trace header response
    curl_setopt($ch, CURLOPT_NOBODY, $header);  //return body
    curl_setopt($ch, CURLOPT_URL, $url);   //curl Targeted URL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_REFERER, $ref);   //fake referer
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    
     if ($p) {
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
     }
     $result = curl_exec($ch);
     curl_close($ch);
     if ($result)
              return $result;
     }
?>	 