<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
//boi 
$boi = explode(" ",$shout['message']);
if(get_ascii($boi[0]) == "boi") 
	{
	//$msg[1] = rawurlencode($boi[1]);
	$u = 'http://www.xemngay.com/quiz/boitinhyeu.aspx?boiyeu=' .$boi[1].$boi[2].$boi[3];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $u);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $kq = curl_exec($ch);
        curl_close($ch);
        preg_match('#<span id="lRs">(.*)</span>#',$kq,$match);
		$ketqua = $match[0];
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b><font color=#990000>Thầy phán</font></b>: <br> " .$match[0]."";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}	
		
?>
