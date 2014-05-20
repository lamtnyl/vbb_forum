<?php
error_reporting(E_ALL & ~E_NOTICE);
@set_time_limit(0);
 
// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('style');
$specialtemplates = array('products');
 
// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/adminfunctions_template.php');
require_once(DIR . '/fshop/fshop_setting.php');
$setting4=setting(4);
if (!can_administer('canadminlanguages'))
{
	print_cp_no_permission();
}
 print_cp_header("RESET ITEM");

   if($_REQUEST['do']=="reset")
     {
   $itemtype = $_REQUEST['id'];
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE itemtype='$itemtype'");   
     while($getreset = $vbulletin->db->fetch_array($query))
      {
      $userid = $getreset['userid'];
     $settingtype = explode("||",$getreset['settingtype']);
         switch ($itemtype) {
    case 1:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$settingtype[0]',customtitle='$settingtype[1]' WHERE userid='$userid'");   
      break;
    case 2:
     $username = $settingtype[0];
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user As user LEFT JOIN userban As userban ON(user.userid = userban.userid) WHERE user.username='$username'");   
    $getinfo = $vbulletin->db->fetch_array($query);
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usergroupid='$getinfo[usergroupid]',displaygroupid='$getinfo[displaygroupid]',usertitle='$getinfo[usertitle]',customtitle='$getinfo[customtitle]' WHERE userid='$getinfo[userid]'");   
   	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "userban WHERE userid='$getinfo[userid]'"); 
      break; 
    case 3:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$settingtype[1]',customtitle='$settingtype[2]' WHERE userid='$settingtype[0]'");   
      break;   
    case 4:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET displaygroupid='$settingtype[0]' WHERE userid='$userid'");   
      break;  
    case 5:
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET username='$settingtype[0]' WHERE userid='$userid'");   
      break;  
     case 6:
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid='$userid'");   
    $gettitleuser = $vbulletin->db->fetch_array($query);  
    $resettitle = preg_replace("/<div[^>]+\>/i", "",$gettitleuser['usertitle']);
    $resettitle = str_replace("</div>","",$resettitle);
          $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$resettitle' WHERE userid='$userid'");   
      break;    
      
                 }
      }
     $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_userlogs WHERE itemtype='$itemtype'");  
     $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE itemtype='$itemtype'");         
  print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_reset.php',2);     
     
     }
   

		
?>