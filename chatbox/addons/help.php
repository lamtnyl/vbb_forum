
<?php
/*Code by Mr.Km - SinhVienVT.Net*/
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
require_once('functions.php');

			$thanhmai = '<br />';
			$huongdan = explode(" ",$shout['message']);
srand((float) microtime() * 10000000);
$input = array ("$thanhmai +<b><font color=black>Thỉnh thầy</b></font>:<font color=green><b>thầy (từ hỏi...)</b></font> ==>VD: thầy có vợ chưa? $thanhmai +<b><font color=black>Bói bài tây</b></font>:<font color=green><b>thầy bói</b></font>==>VD:thầy bói cho con 1 bài nào? $thanhmai +<b><font color=black>Check Yahoo</b></font>:<font color=green><b>check nick_cần_check</b></font> ==>VD:check minhloidotnet $thanhmai +<b><font color=black>Lấy avatar</b></font>:<font color=green><b>avatar nick_cần_lấy</b></font> ==>VD:avatar minhloidotnet $thanhmai +<b><font color=black>Dịch thuật</b></font>:<font color=green><b>AV hoặc VA từ_cần_dịch</b></font> ==>VD:AV love hoặc VA yêu $thanhmai +<b><font color=black>Kết quả xổ số</b></font>:<font color=green><b>kqxs</b></font> ==>VD:kqxs $thanhmai +<b><font color=black>Bot kể truyện</b></font>:<font color=green><b>truyencuoi</b></font> ==>VD:truyencuoi $thanhmai +<b><font color=black>Xem thời tiết</b></font>:<font color=green><b>thoitiet tên_tỉnh (viết liền không dấu)</b></font> ==>VD: thoitiet hanoi $thanhmai +<b><font color=black>Xem tỷ giá ngoại tệ</b></font>:<font color=green><b>nt</b></font> $thanhmai +<b><font color=black>Bói tình yêu</b></font>:<font color=green><b>bói bạn+người ấy </b></font> ==>VD:boi anh+em $thanhmai +<b><font color=black>Xem giờ</b></font>:<font color=green><b>mấy giờ</b></font> ==>VD: mấy giờ rồi Bot ");
$rand_keys = array_rand($input, 1);
$output = $input[$rand_keys];
for($i=1;$i<100;$i++)
{
if (preg_match('/^(hướng dẫn|huongdan|huong dan)$/si',$shout['message']) || preg_match('/^(hướng dẫn|huongdan||huong dan)\s/si',$shout['message']))
		{		$shout['message'] = "isme > $shout[userid] > $shout[username] > $shout[dateline] > <font color=green><b>Bot hướng dẫn</b></font></a>: ".$output."";
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