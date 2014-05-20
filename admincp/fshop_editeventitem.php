<?php
error_reporting(E_ALL & ~E_NOTICE);
define('CVS_REVISION', '$RCSfile$ - $Revision: 34940 $');
define('NOZIP', 1);

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('style');
$specialtemplates = array('products');
 
// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/fshop/fshop_setting.php');
$setting4=setting(4);
if (!can_administer('canadminlanguages'))
{
	print_cp_no_permission();
}

  if($_GET['submit']=="DELETE")
{
    $id = $_GET['eventid'];
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$id'");    
 print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventitemmanager.php',2);  
 
}

 elseif($_GET['submit']=="DONE")
{
    $id = $_GET['eventid'];
    $eventname = $_GET['eventname'];
    $eventimg = $_GET['eventimg'];
    $eventamount = $_GET['amount'];
    $eventrequire = $_GET['require'];
    $eventpercent = $_GET['percent'];
    $eventboxid = $_GET['boxid'];
   
  	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_eventitem SET name='$eventname',image='$eventimg',amount='$eventamount',percent='$eventpercent',boxid='$eventboxid',requiream='$eventrequire'  WHERE id='$id'"); 
    print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventitemmanager.php',2);  
    }
   
    $id = $_GET['id'];
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$id'");   
    $eventitem = $vbulletin->db->fetch_array($query);
    print_cp_header("EDIT EVENT ITEM");
	echo "<form name='edititems' action='fshop_editeventitem.php' method='GET'>";
	print_table_start();

    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
    print_input_row('<b>Name</b>', 'eventname',$eventitem['name']);
    print_input_row('Image','eventimg',$eventitem['image'],0,60);
    print_input_row('Amount', 'amount',$eventitem['amount'],0,5); 
    print_input_row('Require', 'require',$eventitem['requiream'],0,5);  
    print_input_row('Percent %', 'percent',$eventitem['percent'],0,10);  
    print_input_row('FORUM ID<br>(Nhập ID của Forum xuất hiện Item)', 'boxid',$eventitem['boxid'],0,50);         
     
   print_table_header("<input type='hidden' name='eventid' value='$id'><input type='submit' class='button' name='submit' value='DONE'> - <input type='reset' class='button' name='submit' value='RESET'> - <input type='submit' class='button' name='submit' value='DELETE'>");
	echo "</form>";
   print_table_footer();  
	print_cp_footer();
 
   
?>



