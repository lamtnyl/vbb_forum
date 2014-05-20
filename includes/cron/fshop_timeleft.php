<?php
$timenow =  TIMENOW;
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft");    
	 while($getitem= $vbulletin->db->fetch_array($query))
   {
     $timeleft = $getitem['timeleft'];
   
      if($timenow >= $timeleft)
       {
       $itemtype =$getitem['itemtype'];
       $userid = $getitem['userid'];
       $settingtype = explode("||",$getitem['settingtype']);
         switch ($itemtype) {
    case 1:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$settingtype[0]',customtitle='$settingtype[1]' WHERE userid='$userid'");   
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
        
   	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE id='$getitem[id]'");    
       }
    
   }
  

?>