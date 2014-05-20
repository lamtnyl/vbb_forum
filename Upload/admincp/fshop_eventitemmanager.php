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
	print_cp_header("EVENT ITEM SETTINGS");
	echo "<form name='settings' action='fshop_addevent.php?add=item' method='POST'>";
	print_table_start();
	print_table_header("ITEM Settings", 15);
	print_cells_row(array("Id","Image","Name","Amounts","Percent","Require","Control"),1,0,-2);
    
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem ORDER BY id desc");
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
      
	echo "<tr><td class='alt1' width='5%'>$itemlist[id]</td><td class='alt1' width='10%'>$displayimg</td><td class='alt1' width='30%'><b>$itemlist[name]</b></td><td class='alt1'><center><b>$itemlist[amountgot] / $itemlist[amount]</b></center></td><td class='alt1'><center><b>$itemlist[percent]%</b></center></td><td class='alt1'><center><b>$itemlist[requiream]</b></center></td><td class='alt1'><Center><input type='button'  class='button' value='Edit' onClick=location.href='fshop_editeventitem.php?do=item&id=$itemlist[id]'></Center></td></tr>";
       
  }	

	print_table_header("<input type='hidden' name='add' value='item'><input type='submit'  class='button' name='submit' value='Add New Item'>", 15);
	echo "</form>";
   print_table_footer();  
	print_cp_footer();

		
?>