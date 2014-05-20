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
	print_cp_header("CREATE ITEM SETTINGS");
	echo "<form name='settings' action='fshop_add.php?add=item' method='POST'>";
	print_table_start();
	print_table_header("ITEM Settings", 15);
	print_cells_row(array("Id","Image","Name","Description","Amounts","Time",$setting4,"Control"),1,0,-2);
    
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items ORDER BY id desc");
  while( $itemlist = $db->fetch_array($query))
   {
    $mieuta = substr($itemlist['des'],0,50);
     if(stristr($itemlist['image'],"http://") || stristr($itemlist['image'],"www."))
      {
       $displayimg="<img src='$itemlist[image]' width='32px' height='32px'>"  ;
      }else
      {
      $displayimg="<img src='../$itemlist[image]' width='32px' height='32px'>"  ;  
      }
      if($itemlist['amount']==-1)
       {
       $itemlist['amount'] = "No Limit"; 
       }
         if($itemlist['time']==-1)
       {
       $itemlist['time'] = "No Limit"; 
       }
       if($itemlist['active']==1)
       {
	echo "<tr><td class='alt1'>$itemlist[id]</td><td class='alt1'>$displayimg</td><td class='alt1'><b>$itemlist[name]</b></td><td class='alt1'>$mieuta</td><td class='alt1'><Center><b>$itemlist[amount]</Center></b></td><td class='alt1'><Center><b>$itemlist[time]</Center></b></td><td class='alt1'><Center><b>$itemlist[gold]</Center></b></td><td class='alt1'><Center><input type='button'  class='button' value='Edit' onClick=location.href='fshop_edit.php?do=item&id=$itemlist[id]'></Center></td></tr>";
        }else
        {
  	echo "<tr><td class='alt1'>$itemlist[id]</td><td class='alt1'>$displayimg</td><td class='alt1'><b><del>$itemlist[name]</del></b></td><td class='alt1'><del>$mieuta</del></td><td class='alt1'><Center><b>$itemlist[amount]</Center></b></td><td class='alt1'><Center><b>$itemlist[time]</Center></b></td><td class='alt1'><Center><b>$itemlist[gold]</Center></b></td><td class='alt1'><Center><input type='button'  class='button' value='Edit' onClick=location.href='fshop_edit.php?do=item&id=$itemlist[id]'></Center></td></tr>";
            
        }
  }	

	print_table_header("<input type='hidden' name='add' value='item'><input type='submit'  class='button' name='submit' value='Add New Item'>", 15);
	echo "</form>";
   print_table_footer();  
	print_cp_footer();

		
?>