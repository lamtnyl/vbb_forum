<?php
require('session_check.php');
include('../includes/config.php');


function msg($msg){
        global $ten_trang;
        $content=file_get_contents("../html/msg1.html");
        $content=str_replace('{khocnhe360_msg}',$msg,$content);
        $content=str_replace('{khocnhe360_pagename}',$ten_trang,$content);
        $js="<link rel=\"stylesheet\" type=\"text/css\" href=\"../includes/style_msg.css\" />\n</head>";
        $content=str_replace('</head>',$js,$content);
        $content=str_replace('"images/','"../images/',$content);
        echo $content;
}

function no_injection($string)
{
$string = htmlspecialchars($string);
$string = trim($string);
$string = stripslashes($string);
return $string;
}

$file=no_injection($_GET['file']);
$file="../web/".$file;
if(file_exists("$file")){
if (!unlink($file)) {
	      $msg='Xin loi he thong khong the xoa file';
	      $msg.='<br>';
	      $msg.='<a href="account.php">Tro ve</a>';
	      msg($msg);
      }
      else{
	      $msg='Da xoa web thanh cong';
	      $msg.='<br>';
	      $msg.='<a href="account.php">Tro ve</a>';
	      msg($msg);
      }
}
else{
           $msg='Xin loi, file khong tin tai';
           $msg.=$file;
           $msg.='<br>';
           $msg.='<a href="account.php">Tro ve</a>';
           msg($msg);
}


?>