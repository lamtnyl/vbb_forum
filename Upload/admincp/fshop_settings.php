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
   	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$active' WHERE id=1"); 
	
	$desactive = $_GET['desactive'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$desactive' WHERE id=2");  
   
   	$tablemoney = $_GET['tablemoney'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$tablemoney' WHERE id=3");  
    
    $moneyname = $_GET['moneyname'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$moneyname' WHERE id=4");  
    
    $colsitemsshop = $_GET['colsitemsshop'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$colsitemsshop' WHERE id=5");  
    
    $rowsitemsshop = $_GET['rowsitemsshop'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$rowsitemsshop' WHERE id=6");  
    
    $colsmyitems = $_GET['colsmyitems'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$colsmyitems' WHERE id=7");  
    
    $rowsmyitems = $_GET['rowsmyitems'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$rowsmyitems' WHERE id=8"); 
    
    $colsviewitems = $_GET['colsviewitems'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$colsviewitems' WHERE id=9");  
    
    $rowsviewitems = $_GET['rowsviewitems'];
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_setting SET setting = '$rowsviewitems' WHERE id=10"); 
    
	header("Location: fshop_settings.php");

}

	print_cp_header("FUN SHOP SETTINGS");
	echo "<form name='settings' action='fshop_settings.php' method='GET'>";
	print_table_start();
	print_table_header("Fun Shop Settings", 2);
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=1");
	$setting = $db->fetch_array($query);
	print_cells_row(array("Fun Shop Active","Value"),1,0,-2);
	print_yes_no_row('Thiết lập để chạy hệ thống Fun Shop', 'active',$setting['setting']);  
	
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=2");
	$setting = $db->fetch_array($query);
	print_cells_row(array("Thông báo","Text"),1,0,-2);
	print_textarea_row('Thông báo khi Turn Off hệ thống', 'desactive',$setting['setting']);  
		print_hr_row();  
        
     
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=3");
	$setting = $db->fetch_array($query);
    print_input_row('<b>Table Money (MYSQL)</b>', 'tablemoney',$setting['setting'],0,9); 
    
    $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=4");
	$setting = $db->fetch_array($query);
    print_input_row('<b>Money Name</b>', 'moneyname',$setting['setting'],0,9); 
	 
  print_cells_row(array("Paging Setting","Value"),1,0,-2);
 $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=5");
	$setting = $db->fetch_array($query);
    print_input_row('Cols Items Shop</b>', 'colsitemsshop',$setting['setting'],0,9); 
    
     $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=6");
	$setting = $db->fetch_array($query);
    print_input_row('Rows Items Shop</b>', 'rowsitemsshop',$setting['setting'],0,9); 
    
     $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=7");
	$setting = $db->fetch_array($query);
    print_input_row('Cols My Items', 'colsmyitems',$setting['setting'],0,9); 
    
     $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=8");
	$setting = $db->fetch_array($query);
    print_input_row('Rows My Items', 'rowsmyitems',$setting['setting'],0,9); 
    
       $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=9");
	$setting = $db->fetch_array($query);
    print_input_row('Cols View Items', 'colsviewitems',$setting['setting'],0,9); 
    
     $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id=10");
	$setting = $db->fetch_array($query);
    print_input_row('Rows View Items', 'rowsviewitems',$setting['setting'],0,9); 




    
   	print_hr_row();  
   
	print_table_header("<input type='submit' name='submit' value='Save Settings'>", 2);
	echo "</form>";
   print_table_footer();  
	print_cp_footer();

		
?>