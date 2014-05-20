<?php
include('config.php');
function new_theme(){
   $theme_scan=scandir("web_themes");
   $themes=count($theme_scan);

   $content="<marquee height=250 direction=up scrolldelay=50 scrollamount=3>\n";
   if($themes<=7)
   {
       for($i=2;$i<$themes;$i++)
            {	
            	if($theme_scan[$i]<>"thumbs.db" && $theme_scan[$i]<>"index.html")
                $content.="<img border=1 src=\"web_themes/".$theme_scan[$i]."/theme.gif\"><br><br>\n";
            }
   }
   else
   {
       $end=$themes-5;
       $loop_start=rand(2,$end);
       $loop_end=$loop_start+5;
                  for($i=$loop_start;$i<$loop_end;$i++)
                  {
                  		if($theme_scan[$i]<>"thumbs.db" && $theme_scan[$i]<>"index.html")
						$content.="<img src=\"web_themes/".$theme_scan[$i]."/theme.gif\"><br><br>\n";
                  }

   }
   $content.="</marquee>";
	return $content;
}

function total(){
	global $ten_trang;
	$web_arr_report=scandir("web");
	$web_report=count($web_arr_report)-2;
	$theme_arr_report=scandir("web_themes");
	$theme_report=count($theme_arr_report)-2;
	$icon_arr_report=scandir("icons");
	$icon_report=count($icon_arr_report)-2;
	$content="Hiện tại ".$ten_trang." đã có tất cả ".$web_report." web, ".$theme_report." theme và  ".$icon_report." biểu tượng cảm xúc.<br>\n";
	return $content;
}

function load_styles_file($file){
	$content=file_get_contents($file);
	$cut=explode('<body>',$content);
	$cut=explode('</body>',$cut['1']);
	$content=$cut['0'];
	return $content;
}

function web_list(){
global $ten_trang;
echo "<h2>Danh sách web trên hệ thống ".$ten_trang."</h2>";
$web_arr=scandir("web");
$number_of_web=count($web_arr);
$content='';
if($number_of_web<=2){
	echo "Hiện tại không có web nào";
}
else{
	for($i=2;$i<$number_of_web;$i++)
	{
		if($web_arr[$i]<>"thumbs.db" && $web_arr[$i]<>"index.html")
		$content.="<a target=\"_blank\" href=\"web/".$web_arr[$i]."\"><img src=\"images/xem.jpg\"></a>\n";
	}
}
return $content;
}

?>