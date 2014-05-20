<?php
$listsetting = explode(",",$settingitem);
$listgroupnoban = explode(";",$listsetting[0]);

 foreach($listgroupnoban As $i)
  {
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup WHERE usergroupid='$i'");   
 $listusergroup = $vbulletin->db->fetch_array($query); 
 $listnamegroup .= "$listusergroup[opentag] + ".$listusergroup['title']."$listusergroup[closetag]<BR>";
  }
if($listsetting[2]==1)
  {
  $messageboxgshop ="<tr><td><b>+ Message </b></td><td> <input type='text' name='messagefshop' class='primary textbox' size='35'></td></tr>"  ;
  }
if($listsetting[3]==1)
  {
  $ajaxcheckbox ="<input type='text' name='usernameban' class='primary textbox' size='30' onKeyUp='checkusername($itemtype,this.value,$getitem)'> <span id='ajaxloadimg'></span>"  ;
  }else
  {
  $ajaxcheckbox ="<input type='text' name='usernameban' class='primary textbox' size='30'>";
  
  } 
$displayusing ="<div style='float:left;width:40%' id='fshoplegend' class='smallfont'>
<h5>Usergroup Can't Be Banned</h5>
$listnamegroup</div>
<div style='float:left;width:2%'>&nbsp;</div>
<div style='float:left;width:50%' id='fshoplegend' class='smallfont'>
<h5>BAN</h5>
<br>
<table>
<tr>
<td width='30%'>
<br><b>+ Username </b></td><td>$ajaxcheckbox</td>
</tr>
 $messageboxgshop
</table>
<br>
</div>
<br clear='left'>
";

?>
