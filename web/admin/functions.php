<?php
require('session_check.php');
function no_injection($string)
{
$string = htmlspecialchars($string);
$string = trim($string);
$string = stripslashes($string);
return $string;
}

function webs(){
$max_in_page=15;
$web_arr=scandir("../web");
$number_of_web=count($web_arr)-2;
$curpage=no_injection($_GET['curpage']);
if($_GET['curpage']=='') $curpage=1;
$currow_start=($curpage-1)*$max_in_page;
$webs='';
if($number_of_web<=0) $webs.="Hiện tại chưa có web nào được tạo";
else
        {
                // Phan hien thi thanh link
                if($number_of_web%$max_in_page==0){ $totalpage=(int)($number_of_web/$max_in_page); } else{  $totalpage=(int)($number_of_web/$max_in_page+1); }
                $webs.="Trang: ";
                  for($page_link=1;$page_link<=$totalpage;$page_link++)
                  {
                           if($page_link==$curpage) $webs.="<font size=6><b><a href=\"?page=web&curpage=".$page_link."\">".$page_link."</a></b></font> | ";
                           else $webs.="<a href=\"?page=web&curpage=".$page_link."\">".$page_link."</a> | ";
                  }
                  $webs.="<hr><br>";
                if($curpage<$totalpage)  //Neu khong phai la trang cuoi cung
                {
                        $currow_end=$curpage*$max_in_page;
                                  for($i=$currow_start;$i<$currow_end;$i++)
                                  {
                                           $j=$i+2;
                                           $k=$i+1;
                                           $file=$web_arr[$j];
                                           $webs.='<img src="images/tic.gif" border="0">';
                                           $webs.="<a href=\"../web/".$file."\" target=\"_blank\"> Xem web số ".$k."</a>\n | --- "
                                           ."<a href=\"delete.php?mode=web&file=".$file."\"><b>XÓA</b></a><br>";
                                  }
                }
                if($curpage==$totalpage) // Neu la trang cuoi cung
                {
                        $currow_end_end=$currow_start+($number_of_web%$max_in_page);
                        for($i=$currow_start;$i<$currow_end_end;$i++)
                                  {
                                           $j=$i+2;
                                           $k=$i+1;
                                           $file=$web_arr[$j];
                                           $webs.='<img src="images/tic.gif" border="0">';
                                           $webs.="<a href=\"../web/".$file."\" target=\"_blank\"> Xem web số ".$k."</a>\n | --- "
                                           ."<a href=\"delete.php?mode=web&file=".$file."\"><b>XÓA</b></a><br>";
                                  }
                }
}
echo $webs;
}

function install(){
	echo "<br>";
	$file=no_injection($_GET['file']);
	if ($file=='') {	
		$new=scandir('../upload');
		$new_num=count($new);
		echo "<h3>Hãy tải theme cần cài đặt lên thư mục Upload</h3>";
		echo "<br>";
		if ($new_num<=2) {
			echo "Hiện tại chưa tìm thấy theme nào để cài đặt";
		}
		for ($i=2;$i<$new_num;$i++){
			if($new[$i]<>"Thumbs.db" && $new[$i]<>"index.html"){
				$theme_name=ucfirst(str_replace('.zip','',$new[$i]));
				echo "<br>";
				echo "Các theme mới tìm thấy:";
				echo "<br>";
				echo $theme_name."<a href=\"account.php?page=install&file=".$new[$i]."\"> -- Cài đặt</a><br>";
			}
		}
	}else {
		if(unzip($file)){
			echo "Cài đặt thành công, nhấp link dưới để quay về";
			echo "<br>";
			echo "<a href='account.php?page=install' >Quay về</a>";
		}else {
			echo "Không thể cài đặt theme này";
		}
	}
}

function unzip($filename){
	$filename='../upload/'.$filename;
	if (file_exists($filename)) {
		include ('pclzip.lib.php');
		$archive = new PclZip($filename);
		$list = $archive->extract(PCLZIP_OPT_PATH, '../web_themes');
		if ($list == 0) echo "Không thể giải nén tập tin";
		unlink($filename);
		return true;
	}else {
		echo "File cài đặt không tồn tại, vui lòng tải nó lên thư mục Upload";
		echo "<br>";
		return false;
	}

}
function update(){
	include('setting.php');
	echo "<br>";
	echo "<center>";
	echo "<h2>Phiên bản hiện tại là ".$version."</h2>";
	echo "<br>";
	echo "<input type=\"button\" value=\"Kiểm tra phiên bản mới\" onclick='javascript: update();' >";
	echo "<div id=\"update_iframe\">";
	echo "</center>";
}

function news(){
	echo "<br>";
	echo "<h3>Trang tin tức cập nhật tự động từ trang chủ khocnhe360</h3>";
	echo "<iframe frameborder=\"0\" scrolling=\"auto\" width=\"100%\" height=600 src=\"http://newskhocnhe360.blogspot.com\"></iframe>";
}
?>