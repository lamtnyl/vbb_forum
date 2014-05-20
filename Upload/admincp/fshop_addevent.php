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

if($_GET['add']=="event")
{
if($_GET['submit']=="DONE")
{
    $vbulletin->input->clean_array_gpc('g', array(
		'timestart'           => TYPE_UNIXTIME,
		'timeend'             => TYPE_UNIXTIME
	
	));
   
    $eventname = $_GET['eventname'];
    $eventimg = $_GET['eventimg'];
    $eventdes = $db->escape_string($_GET['eventdes']);
    $eventamount = $_GET['eventamount'];
    $eventgold = $_GET['eventgold'];
    $timestart = $_GET['timestart'];
    $timeend = $_GET['timeend'];
    $award = $_GET['award'];
    $amountaw = $_GET['amountaw'];
    $players = $_GET['players'];
    $eventactive = $_GET['active'];
    $listselectitem = $_GET['listselectitem'];
    if($listselectitem[0]=="")
    {
     $listselectitem ="";   
    }else
    {
    $listselectitem = implode(",",$listselectitem); 
    }
    
    
  $vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_event
				(`name`,
                `image`,
                `des`,
                `timestart`,
                `timeend`,
                `players`,
                `award`,
                `gold`,
                `amountaw`,
                `itemrequire`,
                `active`           
				)
			VALUES
				('$eventname',
                '$eventimg',
                '$eventdes',
                '$timestart',
                '$timeend',
                '$players',
                '$award',
                '$eventgold',
                '$amountaw',
                '$listselectitem',
                '$eventactive'  )
		");    
  
  
    print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventmanager.php',2);  
    }
   
  
    print_cp_header("ADD EVENT");
	echo "<form name='edititems' action='fshop_addevent.php?add=event' method='GET'>";
	print_table_start();
   
    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
	print_yes_no_row('<b>ACTIVE ITEM</b>', 'active',1);  
    print_input_row('Name', 'eventname','');
    print_input_row('Image','eventimg','',0,60);
    print_textarea_row('Description', 'eventdes','');   
    print_time_row($vbphrase['fshop_timestart'], 'timestart','', 0);
    print_time_row($vbphrase['fshop_timeend'], 'timeend','', 0);
    print_input_row('Award', 'award','',0,30);  
    print_input_row('Amount Awards', 'amountaw','',0,5); 
    print_input_row('Number of Players', 'players','',0,5);  
    print_input_row('Event '.$setting4, 'eventgold','',0,10);  
   	print_hr_row();  
    
    print_cells_row(array("Item Require","Value"),1,0,-2);
    
      $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem ORDER BY id DESC");   
    while($getinfoitem = $vbulletin->db->fetch_array($query))
     {
     
          $listselect .="<option value='$getinfoitem[id]'>$getinfoitem[name]</option>";      
      }
  
    
     print_cells_row(array("<b>ITEM REQUIRE</b>","
     <select name='listselectitem[]' size='7' multiple='multiple'>
    $listselect</select>"),0,0,-2);
   
    print_table_header("<input type='hidden' name='add' value='event'><input type='submit' class='button' name='submit' value='DONE'>");
	echo "</form>";
    print_table_footer();  
	print_cp_footer();
 }
 if($_GET['add']=="item")
{
    if($_GET['submit']=="DONE")
     {
    $eventname = $_GET['eventname'];
    $eventimg = $_GET['eventimg'];
    $eventamount = $_GET['amount'];
    $eventrequire = $_GET['require'];
    $eventpercent = $_GET['percent'];
    $eventboxid = $_GET['boxid'];
   
   $vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_eventitem
				(`name`,
                `image`,
                `amount`,
                `requiream`,
                `percent`,
                `boxid`       
				)
			VALUES
				('$eventname',
                '$eventimg',
                '$eventamount',
                '$eventrequire',
                '$eventpercent',
                '$eventboxid')
		");    
  
  
    print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventitemmanager.php',2);  
    }
   
    print_cp_header("ADD EVENT ITEM");
	echo "<form name='edititems' action='fshop_addevent.php?add=item' method='GET'>";
	print_table_start();

    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
    print_input_row('<b>Name</b>', 'eventname','');
    print_input_row('Image','eventimg','',0,60);
    print_input_row('Amount', 'amount','',0,5); 
    print_input_row('Require', 'require','',0,5);  
    print_input_row('Percent %', 'percent','',0,10);  
    print_input_row('FORUM ID<br>(Nhập ID của Forum xuất hiện Item)', 'boxid','',0,50);         
     
   print_table_header("<input type='hidden' name='add' value='item'><input type='submit' class='button' name='submit' value='DONE'>");
	echo "</form>";
   print_table_footer();  
	print_cp_footer();    
    
    
}    
    
?>



