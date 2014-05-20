
<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');

// He thong dich Anh - Viet va Viet-anh
$msg = spliti (" ",$shout['message'],2);
if(get_ascii($msg[0]) == "AV") 
	{
	$msg[1] = rawurlencode($msg[1]);
	$u = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&langpair=en|vi&callback=foo&context=bar&q=' . $msg[1];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $u);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $translate = curl_exec($ch);
        curl_close($ch);
        $translate = spliti("\"",$translate);
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> <b>từ đó có nghĩa là: </b><font color=red><b>" .$translate[3]."</b></font> $shout[username] à";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if(get_ascii($msg[0]) == "VA") 
{
		$msg[1] = rawurlencode($msg[1]);
         $u = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&langpair=vi|en&callback=foo&context=bar&q=' . $msg[1];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $u);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $translate = curl_exec($ch);
        curl_close($ch);
        $translate = spliti("\"",$translate);
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b> <b>từ đó có nghĩa là: </b><font color=red><b>" .$translate[3]."</b></font> $shout[username] à";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);

}



?>