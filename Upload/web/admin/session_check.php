<?
  session_start();
   if(!session_is_registered('user_input')){ header("location:login.php");}
?>