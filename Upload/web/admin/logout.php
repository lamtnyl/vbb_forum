<?
  session_start();
  $user_input="";
  $pass_input="";
  session_unregister("user_input");
  session_unregister("pass_input");
  header("location:login.php");
?>