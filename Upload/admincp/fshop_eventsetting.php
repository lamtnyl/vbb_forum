<?php
error_reporting(E_ALL & ~E_NOTICE);
@set_time_limit(0);
 
// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('style');
$specialtemplates = array('products');
 
// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/adminfunctions_template.php');
if (!can_administer('canadminlanguages'))
{
	print_cp_no_permission();
}
if($_GET['submit']=="Save Settings")
{
    $active = $_GET['active'];
   	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$active' WHERE id=12"); 
	
	$useridmanager = $_GET['useridmanager'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$useridmanager' WHERE id=11");  
   
	header("Location: fshop_eventsetting.php");

}

	print_cp_header("FUN SHOP EVENT SETTINGS");
	echo "<form name='settings' action='fshop_eventsetting.php' method='GET'>";
	print_table_start();
	print_table_header("Fun Shop Event Settings", 2);
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=12");
	$setting = $db->fetch_array($query);
	print_cells_row(array("Event Active","Value"),1,0,-2);
	print_yes_no_row('<b>Thiết lập để chạy hệ thống Event</b>', 'active',$setting['setting']);  
	
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=11");
	$setting = $db->fetch_array($query);
    print_input_row('<b>Userid Manager </b><br><i>(Dùng \' , \' nếu nhiều hơn 1 userid )</i>', 'useridmanager',$setting['setting'],0,20); 
       
   	print_hr_row();  
   
	print_table_header("<input type='submit' name='submit' value='Save Settings'>", 2);
	echo "</form>";
   print_table_footer();  
	print_cp_footer();

		
?>