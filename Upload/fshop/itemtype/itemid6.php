<?php
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='6'");   
    $checkuser = $vbulletin->db->fetch_array($query);
      if($checkuser['id'])
      {
  $displayusing ="<b>$vbphrase[fshop_usingeffect]</b>";   
      }
       else
      {
$listeffect = explode(",",$settingitem);
$k=1;

foreach ($listeffect As $i)
 {
  
 $arrayk = array(1,2,3,4);
  if(in_array($k,$arrayk))
    {
    $effecttitle = strip_tags($usertitle);    
    }else
    {
        $effecttitle = $usertitle;      
    }
 
if($i=="on")
     {
      $showeffect .="<tr><td><input type='radio' name='effect' value='$k'> &nbsp;</td><td><div id='fs_rb$k-0'>$effecttitle</div></td></tr>"  ;
     }
  $k++; 
    
 }
$displayusing ="
<div style='width:70%' id='fshoplegend' class='smallfont'>
<h5>EFFECT</h5>
<br>
<table>
$showeffect
</table>
<br>
</div>
<br>
";
}
?>
