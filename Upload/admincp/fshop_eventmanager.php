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
	echo "<form name='settings' action='fshop_addevent.php?add=event' method='POST'>";
	print_table_start();
	print_table_header("Event Settings", 15);
	print_cells_row(array("<center>Image<center>","Info","$vbphrase[fshop_eventitems]"),1,0,-2);
   
	$query = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event ORDER BY id desc");
  while( $eventlist = $db->fetch_array($query))
   {
    
    $mieuta = substr($eventlist['des'],0,50);
     if(stristr($eventlist['image'],"http://") || stristr($eventlist['image'],"www."))
      {
       $displayimg="<img src='$eventlist[image]' width='70px' height='70px'>"  ;
      }else
      {
      $displayimg="<img src='../$eventlist[image]' width='70px' height='70px'>"  ;  
      }
      if($eventlist['amountaw']==-1)
       {
       $eventlist['amountaw'] = "No Limit"; 
       }
      if($eventlist['players']==-1)
       {
       $eventlist['players'] = "No Limit"; 
       }
       
      $fetchitem = explode(",",$eventlist['itemrequire']) ;
      unset($items);
     for($k=0;$k<count($fetchitem);$k++)
     {
      $queryb = $db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$fetchitem[$k]'");
    $row =  $db->fetch_array($queryb);
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
       
      $fetchplayerjoin= explode(",",$eventlist['playerjoin']);
      $countplayerjoin = count($fetchplayerjoin);
      if($fetchplayerjoin[0]=="")
       {
      $countplayerjoin=0;  
       }
      $converttimestart = substr(convert_timestamp_to_date($eventlist['timestart']),0,10);
      $converttimeend = substr(convert_timestamp_to_date($eventlist['timeend']),0,10);
       if($eventlist['active']==1)
       {
	echo "<tr><td class='alt1' width='10%' valign='top'><center>$displayimg <br><input type='button'  class='button' value=' Edit ' onClick=location.href='fshop_editevent.php?id=$eventlist[id]'></center></td>
    <td class='alt1' valign='top' width='30%'>
    <div style='font-size:11px'>
    $vbphrase[fshop_itemevent] : <b><font color='red'>$eventlist[name]</font></b><br>
    $vbphrase[fshop_award] : <b><font color='blue'>$eventlist[award]</font></b><br>
    $vbphrase[fshop_gjoin] : <b><u>$eventlist[gold]</u> $setting4</b><bR>
    $vbphrase[fshop_playerevent] : <b><u>$countplayerjoin</u> / <u>$eventlist[players]</u></b><bR>
    $vbphrase[fshop_amountevent] : <b><u>$eventlist[amountcombined]</u> / <u>$eventlist[amountaw]</u></b><bR>
     $vbphrase[fshop_timestart] : <b>$converttimestart</b><bR>
      $vbphrase[fshop_timeend] : <b>$converttimeend</b>
    </div>
        </b><br></td><td class='alt1' valign='top' width='60%'><div style='font-size:8px'>$showitem</td></tr>";
        }else
        {
  	echo "<tr><td class='alt1' width='10%' valign='top'><center>$displayimg <br><input type='button'  class='button' value=' Edit ' onClick=location.href='fshop_editevent.php?id=$eventlist[id]'></center></td>
    <td class='alt1' valign='top' width='30%'>
    <div style='font-size:11px'>
    <del>$vbphrase[fshop_itemevent] : <b><font color='red'>$eventlist[name]</font></b></del><br>
    $vbphrase[fshop_award] : <b><font color='blue'>$eventlist[award]</font></b><br>
    $vbphrase[fshop_gjoin] : <b><u>$eventlist[gold]</u> $setting4</b><bR>
    $vbphrase[fshop_playerevent] : <b><u>$countplayerjoin</u> / <u>$eventlist[players]</u></b><bR>
    $vbphrase[fshop_amountevent] : <b><u>$eventlist[amountcombined]</u> / <u>$eventlist[amountaw]</u></b><bR>
     $vbphrase[fshop_timestart] : <b>$converttimestart</b><bR>
      $vbphrase[fshop_timeend] : <b>$converttimeend</b>
    </div>
        </b><br></td><td class='alt1' valign='top' width='60%'><div style='font-size:8px'>$showitem</td></tr>";        
        }
  }	

	print_table_header("<input type='submit'  class='button' name='submit' value='Add New Event'>", 15);
	echo "</form>";
   print_table_footer();  
	print_cp_footer();

		
?>