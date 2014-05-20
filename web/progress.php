<?php
if (file_exists('includes/config.php')) {
	include('includes/config.php');
}else{
	echo "<center><h2>He thong khong load duoc file includes/config.php</h2></center>";
	exit();
}

// ---------------------------------------------------------------------

function progress(){
	global $ten_trang,$message,$duong_dan;
	$username=no_injection($_POST['username']);
	$sendto=no_injection($_POST['sendto']);
	$fullname=make_webname();
	$scrolltext=no_injection($_POST['scrolltext']);
	$scrolltext="<marquee>".$scrolltext." - Trang này được bạn ".$username." gửi tặng bạn ".$sendto." trên hệ thống ".$ten_trang.", chúc hai bạn vui vẻ </marquee>";
	$theme=no_injection($_POST['theme']);
	$color=no_injection($_POST['color']);
	$content=no_injection($_POST['content']);
	$content=add_img($content);
	
	    
	// Load theme
	$loadtheme="web_themes/".$theme."/theme.html";
	if(file_exists("$loadtheme")){
			$opened = fopen ($loadtheme,"r");
			$final = fread ($opened,filesize($loadtheme));
			fclose ($opened);
			$final=str_replace("{scrolltext}", "$scrolltext", $final);
			$final=str_replace("{content}", "$content", $final);
			$final=str_replace("<img src=\"", "<img src=\"../web_themes/".$theme."/", $final);
			$final=str_replace("background=\"", "background=\"../web_themes/".$theme."/", $final);
			$final=str_replace('{Ninja9x_pagename}',$ten_trang,$final);
			// Tao file
			$new=fopen("$fullname","x");
			fwrite($new,$final);
			fclose($new);
			
			$duong_dan=$duong_dan."/".$fullname;
			$msg.="<center>\n";
			$msg.="Trang của bạn đã được tạo thành công";
			$msg.="<br>\n";
			$msg.="<a target='_blank' href=\"$fullname\">Vui lòng kích vào đây để xem</a>\n";
			$msg.="<br><br>\n";
			$msg.="Hoặc gõ nick bạn bè vào ô dưới để gửi cho bạn bè\n";
			$msg.="<br>\n";
		
			$msg.='<INPUT class=input size=16 name=nick value="" style="width: 250px; height: 21px">';
			$msg.='<INPUT class=input onclick=Send() type=submit value="Gửi đi" onfocus="javascript: NoViet();">';
			$msg.='<br>';
			$msg.="<a href=\"index.php\"><img border='0' src=\"images/back.gif\"></a></center>\n";
			msg($msg);
	}else{
			$msg="Hệ thống không load được theme vui lòng liên hệ ban quản trị, xin cảm ơn bạn";
			$msg.='<br>';
			$msg.="<a href=\"index.php\"><img border='0' src=\"images/back.gif\"></a></center>\n";
			msg($msg);	
	}

}

function add_img($content){
	global $color;
	$content = str_replace("\n", "<br>", $content);
	$content = str_replace("((", "<img border=\"0\" src=\"../icons/", $content);
	$content = str_replace("))", "\" border=\"0\">", $content);
	$content="<font color=\"".$color."\">".$content."</font>";
	return $content;
}

function no_injection($string)
{
$string = htmlspecialchars($string);
$string = trim($string);
$string = stripslashes($string);
return $string;
}

function make_webname(){
	$cur_web=scandir('web');
	$web_count=count($cur_web);
	if($web_count<=2) $webname="web/1.htm";
	else{
		for ($i=2;$i<($web_count);$i++){
			$split_webname=explode('.',$cur_web[$i]);
			$add=$split_webname[0]+1;
			$fullname="web/".$add.".htm";
			if(!file_exists($fullname)){
				$webname=$fullname;
				break;
			}
		}
	}
	return $webname;
}

function msg($msg){
	global $message,$duong_dan,$page_name;
	$content=file_get_contents("html/msg.html");
	$content=str_replace('{Ninja9x_pagename}',$ten_trang,$content);
	$js="<script language=javascript src=\"includes/js/checkinput.js\"></script>\n";
	$js.="<script language=Javascript src=\"includes/js/viettyping.js\"></SCRIPT>\n";
	$js.="<link rel=\"stylesheet\" type=\"text/css\" href=\"includes/style_msg.css\" />\n";
	$js.="</head>";
	$content=str_replace('</head>',$js,$content);
	$content=str_replace('{Ninja9x_msg}',$msg,$content);
	$content=str_replace('{Ninja9x_message}',$message,$content);
	$content=str_replace('{Ninja9x_svr}',$duong_dan,$content);
	$content=str_replace('"images/',"\"images/",$content);
	echo $content;	
}

progress();
?>