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


   if($_GET['submit']=="GO")
     {
   	echo "<form name='settings' action='fshop_request.php?do=reset&id=$_GET[itemtype]' method='POST'>";     
   	print_table_start();
	print_table_header("RESET ITEM");
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_itemtype WHERE id='$_GET[itemtype]'");   
   $gettype = $vbulletin->db->fetch_array($query);
  	print_description_row("Are you sure you want to Reset Item Type : <b>$gettype[typeitem]</b> ");
	print_submit_row($vbphrase['yes'], '', 2, $vbphrase['no']);
  echo "</form>";
	
   print_table_footer();  
	print_cp_footer();
     }
 
	echo "<form name='settings' action='fshop_reset.php' method='GET'>";
	print_table_start();
	print_table_header("RESET ITEM");
    print_cells_row(array("NOTE","Select Item Type"),1,0,-2);
     	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_itemtype");   
    while($gettype = $vbulletin->db->fetch_array($query))
      {
      $listtype .="<option value='$gettype[id]' alt='$gettype[des]'>$gettype[typeitem]</option>";  
      }
    print_cells_row(array("Reset All","<select name='itemtype' id='itemtype')'>$listtype</select>"),0,0,-2);

  	print_description_row('<br>
		<div id="hiddestype" style="border:2px inset;display:none;">	<ul >
        <li>
	   <b><font color="green">
        <div id="loaddestype"></div>
       </font></b>
       </li>
       </ul></div>
	');

		print_table_header("<input type='submit' name='submit' class='button' value='GO'>");
	echo "</form>";
   print_table_footer();  
	print_cp_footer();
		
?>