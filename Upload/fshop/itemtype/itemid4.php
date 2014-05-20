<?php
$listsetting = explode(",",$settingitem);
$listgroupnoban = explode(";",$listsetting[0]);

 foreach($listgroupnoban As $i)
  {
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup WHERE usergroupid='$i'");   
 $listusergroup = $vbulletin->db->fetch_array($query); 
 $listnamegroup .= "&nbsp;&nbsp;&nbsp;<input type='radio' name='groupcolor' value='$listusergroup[usergroupid]'>  $listusergroup[opentag] ".$listusergroup['title']."$listusergroup[closetag]<BR>";
  }

$displayusing ="<div style='width:70%' id='fshoplegend' class='smallfont'>
<h5>Usergroups Can Be Changed Color</h5>
$listnamegroup
</div>
<br>
<br>
";

?>
