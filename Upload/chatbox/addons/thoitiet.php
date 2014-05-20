<?php
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
$tmp = explode(" ",$shout['message']);
$gio = gmdate("h:i A", time()+7*3600);
for($i=0 ; $i<20 ; ++$i)
{
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "hanoi") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0006&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$vitri = $att['observationpoint'];
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: Thời tiết tại $vitri  <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "bmt") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7213884&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "camau") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0031&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "campha") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7213346&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "cantho") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0004&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "caobang") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0020&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "dalat") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:8456&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "danang") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0027&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "donghoi") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0027&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "gialai") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7208781&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "hagiang") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7208375&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "hatinh") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7208075&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "haiphong") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0005&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "tphcm") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0007&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "hue") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0009&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "laocai") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0019&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "longxuyen") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:19163&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "mongcai") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7201559&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "namdinh") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0011&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "nhatrang") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0029&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "phanthiet") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0012&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "pleiku") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7196808&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "quynhon") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:27117&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "rachgia") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:7195640&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "thainguyen") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0015&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "vinh") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0026&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}
if (get_ascii($tmp[$i]) == "thoitiet" && get_ascii($tmp[$i+1])== "vungtau") 
		{
		$xml = new SimpleXMLElement('http://weather.msn.com/data.aspx?wealocations=wc:VMXX0018&weadegreetype=C', NULL, TRUE);
		$att = $xml->weather->current[0]->attributes();
		$nhietdo = $att['temperature'];
		$doam =  $att['humidity'];
		$tocdo = $att['windspeed'] ;
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname</b>: <br><b>Nhiệt độ: " . $nhietdo . " độ C <br>  Độ ẩm: " . $doam . " % <br> Gió: " . $tocdo . " km/h";
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
