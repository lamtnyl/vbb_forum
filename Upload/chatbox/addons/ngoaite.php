<?php
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
if (get_ascii($shout['message']) == "nt" ) 
		{		
		$Link = new SimpleXMLElement('http://www.vietcombank.com.vn/exchangerates/ExrateXML.aspx',NULL,true);

   		foreach($Link->Exrate as $Exrate)
		{
		
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>:<br>Tên ngoại tệ: ".$Exrate['CurrencyName']. " Mua vào :" .$Exrate['Buy']. "VNĐ Bán ra : " .$Exrate['Sell']."VNĐ";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		
		}
		}
		
?>