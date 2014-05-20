<?php
$listsetting = explode(",",$settingitem);
if($listsetting[1]==1)
  {
  $ajaxcheckbox ="<input type='text' name='fakenick' class='primary textbox' size='30' onKeyUp='checkusername($itemtype,this.value,$getitem)'> <span id='ajaxloadimg'></span>"  ;
  }else
  {
  $ajaxcheckbox ="<input type='text' name='fakenick' class='primary textbox' size='30'>";
  
  } 
$displayusing ="
<div style='width:70%' id='fshoplegend' class='smallfont'>
<h5>BAN</h5>
<br>
<table width='100%'>
<tr>
<td width='20%'>
<br><b>+ Username </b></td><td>$ajaxcheckbox</td>
</tr>
 $messageboxgshop

</table>
<br>
</div>
<br>
";

?>
