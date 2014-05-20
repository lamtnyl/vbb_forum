
<?php
/*
Code Bot Shout Box Tra Kết quả sổ xố  Ver 1.0
Code by BluE HearT - WwW.VnSoft4You.CoM - WwW.BluEHearT.OrG
Mail: webmaster@blueheart.org
Y!M: potaydotcomdotvn_blueheart
*/
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');
$soxo = spliti (" ",$shout['message'],2);
if(get_ascii($soxo[0]) == "kqxs") 
	{
		
		$u = 'http://www.xosothudo.com.vn/default.aspx?tabid=424';
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
		//$kq = preg_replace("/&nbsp;/","",$kq) ;
        preg_match('#<span id="ctl04_ctl07_lbdb" class="giaidb" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$dacbiet);
		$giaidb = $dacbiet[0];
		preg_match('#<span id="ctl04_ctl07_lbNhat" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$nhat);
		$ketqua1 = $nhat[0];
		preg_match('#<span id="ctl04_ctl07_lbNhi" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$nhi);
		$ketqua2 = $nhi[0];
		preg_match('#<span id="ctl04_ctl07_lbBa" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$giaiba);
		$ketqua3 = $giaiba[0];
		preg_match('#<span id="ctl04_ctl07_lbTu" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$giaitu);
		$ketqua4 = $giaitu[0];
		preg_match('#<span id="ctl04_ctl07_lbNam" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$giainam);
		$ketqua5 = $giainam[0];
		preg_match('#<span id="ctl04_ctl07_lbSau" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$giaisau);
		$ketqua6 = $giaisau[0];
		preg_match('#<span id="ctl04_ctl07_lbBay" class="giaithuong" style="display:inline-block;width:100%;">(.*)</span>#',$kq,$giaibay);
		$ketqua7 = $giaibay[0];
		preg_match('#<span class="style2">(.*)</span>#',$kq,$ktmb);
		$tengiai = $ktmb[0];
		preg_match('#<span id="ctl04_ctl07_lbNgaymothuong" class="style3">(.*)</span>#',$kq,$ngaymothuong);
		$ngaymo = $ngaymothuong[0];
		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <b>$botname<font color=green> kết quả xổ số</font></b>:<br><b><font color=#0011FF> ".$tengiai."<br>".$ngaymo."</font><br>Giải đặc biệt:<font color=red> " .$giaidb."</font><br> Giải nhất: <font color=green>".$ketqua1."</font><br> Giải nhì: <font color=green>".$ketqua2."</font><br> Giải ba:<font color=green> ".$ketqua3."</font><br> Giải Tư:<font color=green> ".$ketqua4."</font><br> Giải năm:<font color=green> ".$ketqua5."</font><br> Giải sáu:<font color=green> ".$ketqua6."</font><br> Giải Bẩy: <font color=green>".$ketqua7."</font></b>";
				$handle = fopen($fcbfile['message'],"a");
					if ($config['remove_badword'])
					{
						$shout['message'] = remove_bad_word($shout['message']);
					}
					fwrite($handle, $shout['message']."\n");
					fclose($handle);
		}	
		?>