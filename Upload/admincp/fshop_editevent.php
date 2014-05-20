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
      $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$id'");   
    $getitem = $vbulletin->db->fetch_array($query);
    $fetchitem = explode(",",$getitem['itemrequire']);
    foreach($fetchitem As $i)
    {
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_eventitem SET amountgot='0' WHERE id='$i'");     
    }
    
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_event WHERE id='$id'");  
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventuser WHERE eventid='$id'");
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventpost WHERE eventid='$id'");  
 print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventmanager.php',2);  
 
}  elseif($_GET['submit']=="RESET EVENT")
{
    $id = $_GET['eventid'];
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$id'");   
    $getitem = $vbulletin->db->fetch_array($query);
    $fetchitem = explode(",",$getitem['itemrequire']);
    foreach($fetchitem As $i)
    {
    $db->query("UPDATE  " . TABLE_PREFIX . "fshop_eventitem SET amountgot='0' WHERE id='$i'");     
    }
    
  	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_event SET amountcombined='0',playerjoin='' WHERE id='$id'"); 
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventuser WHERE eventid='$id'");
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventpost WHERE eventid='$id'");   
       
 print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventmanager.php',2);  
 
}

 elseif($_GET['submit']=="DONE")
{
    $vbulletin->input->clean_array_gpc('g', array(
		'timestart'           => TYPE_UNIXTIME,
		'timeend'             => TYPE_UNIXTIME
	
	));
   
    $id = $_GET['eventid'];
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
  	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_event SET name='$eventname',image='$eventimg',des='$eventdes',timestart='$timestart',timeend='$timeend',gold='$eventgold',award='$award',amountaw='$amountaw',players='$players',itemrequire='$listselectitem',active='$eventactive'  WHERE id='$id'"); 
    print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_eventmanager.php',2);  
    }
   
    $id = $_GET['id'];
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$id'");   
    $eventitem = $vbulletin->db->fetch_array($query);
    print_cp_header("EDIT EVENT");
	echo "<form name='edititems' action='fshop_editevent.php' method='GET'>";
	print_table_start();
	print_table_header(strtoupper($getnametype['typeitem']));
   
    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
	print_yes_no_row('<b>ACTIVE ITEM</b>', 'active',$eventitem['active']);  
    print_input_row('Name', 'eventname',$eventitem['name']);
    print_input_row('Image','eventimg',$eventitem['image'],0,60);
    print_textarea_row('Description', 'eventdes',$eventitem['des']);   
    print_time_row($vbphrase['fshop_timestart'], 'timestart', $eventitem['timestart'], 0);
    print_time_row($vbphrase['fshop_timeend'], 'timeend', $eventitem['timeend'], 0);
    print_input_row('Award', 'award',$eventitem['award'],0,30);  
    print_input_row('Amount Awards', 'amountaw',$eventitem['amountaw'],0,5); 
    print_input_row('Number of Players', 'players',$eventitem['players'],0,5);  
    print_input_row('Event '.$setting4, 'eventgold',$eventitem['gold'],0,10);  
   	print_hr_row();  
    
    print_cells_row(array("Item Require","Value"),1,0,-2);
    
    
      $fetchitem = explode(",",$eventitem['itemrequire'])  ;
      $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem ORDER BY id DESC");   
    while($getinfoitem = $vbulletin->db->fetch_array($query))
     {
      
          if(in_array($getinfoitem['id'],$fetchitem))
         {
         $listselect .="<option value='$getinfoitem[id]' selected>$getinfoitem[name]</option>";  
         }else
         {
          $listselect .="<option value='$getinfoitem[id]'>$getinfoitem[name]</option>";      
         }
 
      }
   for($k=0;$k<count($fetchitem);$k++)
     {
      $query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$fetchitem[$k]'");
    $row =  $db->fetch_array($query);
    $items[] = array(1 => $row['name'],2 => $row['image'],3 => $row['requiream'],4 => $row['percent'],5 => $row['amount'],6 => $row['amountgot']);
     }
   
        $numcols =3;
         $numitems = count($items);
          $numrows = ceil($numitems/$numcols);
           $showitem =  '<table width="100%">';
        for ($row=1; $row <= $numrows; $row++)
        {
            $cell = 0;
           $showitem .= ' <tr>'."\n";
            for ($col=1; $col <= $numcols; $col++)
            {
           $showitem .= '  <td width="'.round(100/$numcols).'%" valign=top>'."\n<div style='font-size:9px'>";
            if ($col===1)
            {
                $cell += $row;
                $nameitem = $items[$cell - 1][1];
                $imageitem = $items[$cell - 1][2];
                $requireitem = $items[$cell - 1][3];
                $percentitem = $items[$cell - 1][4];
                $amountitem = $items[$cell - 1][5];
                 if($amountitem==-1)
                {
                 $amountitem="No Limit";   
                }
                $amountgot = $items[$cell - 1][6];
            if($nameitem)
              {
                 $showitem .="<div style='float:left'><img src='$imageitem' width='45px' height='45px'>&nbsp; </div><div><font color='red'><b>$vbphrase[fshop_itemname] : $nameitem</font><br>$vbphrase[fshop_amount] : $amountgot / $amountitem<br>$vbphrase[fshop_itemrequire] : $requireitem<br>$vbphrase[fshop_itempercent] : $percentitem% </b></div>
";
                 }  }
          
            else {
             $cell += $numrows;
                $nameitem = $items[$cell - 1][1];
                $imageitem = $items[$cell - 1][2];
                $requireitem = $items[$cell - 1][3];
                $percentitem = $items[$cell - 1][4];
                $amountitem = $items[$cell - 1][5];
                 if($amountitem==-1)
                {
                 $amountitem="No Limit";   
                }
                $amountgot = $items[$cell - 1][6];
               if($nameitem)
              {
                  $showitem .="<div style='float:left'><img src='$imageitem' width='45px' height='45px'>&nbsp; </div><div><font color='red'><b>$vbphrase[fshop_itemname] : $nameitem</font><br>$vbphrase[fshop_amount] : $amountgot / $amountitem<br>$vbphrase[fshop_itemrequire] : $requireitem<br>$vbphrase[fshop_itempercent] : $percentitem% </b></div>
";
                 }  }
            $showitem .='</div>  </td>'."\n";
            }
            $showitem .= ' </tr>'."\n";
        
        }
         $showitem .= '</table>';     
    
     print_cells_row(array("<b>ITEM REQUIRE</b>","
     <select name='listselectitem[]' size='7' multiple='multiple'>
    $listselect</select>"),0,0,-2);
   
    print_cells_row(array("<b>INFO</b>","$showitem"),0,0,-2);
   print_table_header("<input type='hidden' name='eventid' value='$id'><input type='submit' class='button' name='submit' value='DONE'> - <input type='submit' class='button' name='submit' value='RESET EVENT'> - <input type='submit' class='button' name='submit' value='DELETE'>");
	echo "</form>";
   echo "<script src='../fshop/script/effecttext.js'></script>" ;
   print_table_footer();  
	print_cp_footer();
 
   
?>



