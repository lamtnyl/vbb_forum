<?php
if (file_exists('../includes/config.php')) {
	include('../includes/config.php');
}else{
	echo "<center><h2>He thong khong load duoc file includes/config.php</h2></center>";
	exit();
}
function no_injection($string)
{
$string = htmlspecialchars($string);
$string = trim($string);
$string = stripslashes($string);
return $string;
}
if (!eregi("login.php",$_SERVER['HTTP_REFERER'])) { die ("<h2>Yeu cau cua ban khong thuc hien duoc</h2>"); }
  $user_input=no_injection($_POST['txtUser']);
  $pass_input=no_injection($_POST['txtPWD']);

//----------------------------------
$check_user_input=ereg("^[a-zA-Z0-9_]+$",$user_input);
$check_pass_input=ereg("^[a-zA-Z0-9_]+$",$user_pass);
//------------------------------------

if ($user_input==$admin && $pass_input==$pass /* && $check_user_input==1 && $check_pass_input==1*/ )
      {
      	  session_start();
          session_register("user_input");
          session_register("pass_input");
          header("location:account.php");
      }
  else{
       header("location:login.php?fall=1");
       }
?>