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
	print_cp_header("VIEWING");
    print_table_start();
	print_table_header("ITEM LIST", 15);
	print_cells_row(array("Id","Image","Name","Username","Time Used","Time Left"),1,0,-2);
    
	$query = $db->query_read("SELECT *,fshop_timeleft.id As idlist FROM " . TABLE_PREFIX . "fshop_timeleft As fshop_timeleft LEFT JOIN " . TABLE_PREFIX . "fshop_items As fshop_items  ON (fshop_timeleft.itemid=fshop_items.id) ORDER BY fshop_timeleft.id desc");
  while( $itemlist = $db->fetch_array($query))
   {

   	$querys = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid=$itemlist[userid]");
        $getusername = $db->fetch_array($querys);
     if(stristr($itemlist['image'],"http://") || stristr($itemlist['image'],"www."))
      {
       $displayimg="<img src='$itemlist[image]' width='32px' height='32px'>"  ;
      }else
      {
      $displayimg="<img src='../$itemlist[image]' width='32px' height='32px'>"  ;  
      }
      
      
  $timeused = convert_timestamp_to_date($itemlist['timeused']);
  $timeleft = convert_timestamp_to_date($itemlist['timeleft']);
       
	echo "<tr><td class='alt1'>$itemlist[idlist]</td><td class='alt1'>$displayimg</td><td class='alt1'><b>$itemlist[name]</b></td><td class='alt1'><Center><b>$getusername[username]</b></center></td><td class='alt1'><Center><b>$timeused</Center></b></td><td class='alt1'><Center><b>$timeleft</Center></b></td></tr>";
  }	


   print_table_footer();  
	print_cp_footer();

		
?>