<?php
$checkusermanager = explode(",",$setting11);
 if(!in_array($userid,$checkusermanager))
   {
    eval('standard_error(Error);');   
   }
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$_GET[idevent]'");   
    $infoevent = $vbulletin->db->fetch_array($query);

                $idevent = $_GET['idevent'];
                $nameevent = $infoevent['name'];
                $imageevent = $infoevent['image'];
                $desevent = $infoevent['des'];
                $timestart =  convert_timestamp_to_date($infoevent['timestart']);
                $timeend =  convert_timestamp_to_date($infoevent['timeend']);
                $players = $infoevent['players'];
                $fsaward = $infoevent['award'];
                $goldevent = $infoevent['gold'];
                $playerjoin = explode(",",$infoevent['playerjoin']);
                $itemlist = explode(",",$infoevent['itemrequire']);
                $active = $infoevent['active'];
                if($players=-1)
                {
                 $players="No Limit";   
                }
   if($active==0)
     {
    	eval('standard_error(Error);');    
     }
  $useridcheck = $_GET['userid'];
  
  $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$useridcheck'");   
  $checkdones = $vbulletin->db->fetch_array($query);
  $checkdone=$checkdones['done'];
  if($checkdone==3 || $checkdone==4)
   {
   $fetchmanager = explode(";",$checkdones['usermanager']) ;
   $gettime = convert_timestamp_to_date($fetchmanager[1]);
  $showmanageraccpet = "<b><font size='2'>$fetchmanager[0]</font> - [ <i>$gettime</i> ]</b>";
   }
   
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid='$useridcheck'");   
   $getusernamecheck = $vbulletin->db->fetch_array($query);
   $getusernamecheck = $getusernamecheck['username'];
   
    $listshow = array();
      foreach($itemlist As $i)  
  {

   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$i'");   
   $infoitem = $vbulletin->db->fetch_array($query);
$k=1;   
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventpost As fshop_eventpost LEFT JOIN " . TABLE_PREFIX . "thread As thread ON(fshop_eventpost.threadid=thread.threadid) WHERE fshop_eventpost.userid='$useridcheck' AND fshop_eventpost.eventid='$idevent' AND fshop_eventpost.itemid='$i'");   
 while($showpost = $vbulletin->db->fetch_array($query))
   {

   $dateline =  convert_timestamp_to_date($showpost[date]);
   $listshow[$i] .="$k - <a href='showthread.php?$showpost[threadid]-$showpost[title]&p=$showpost[postid]#post$showpost[postid]'>$showpost[title]</a> ( $dateline )<br>";
   $k++; 
   }
      
$listcheckitem .="
<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolitem'>
<img class='sgiconevent' src='$infoitem[image]' /> 
</div>
<div class='maincol'>
<b>
$vbphrase[fshop_itemevent] : <font color='red'>$infoitem[name]</font> - $vbphrase[fshop_itemrequire] : <font color='red'><u>$infoitem[requiream]</u></font> <br>
$listshow[$i]


</b>
</div>
</li></ul></div>";
    }
 

 	$templater = vB_Template::create('fshop_managercheck');
    $templater->register('idevent', $idevent);
    $templater->register('nameevent', $nameevent);
    $templater->register('imageevent', $imageevent);
    $templater->register('timeend', $timeend);
    $templater->register('timestart', $timestart);
    $templater->register('players', $players);
    $templater->register('fsaward', $fsaward);
    $templater->register('goldevent', $goldevent);
    $templater->register('desevent', $desevent);
    $templater->register('listeventitem', $listeventitem);
    $templater->register('showbuttonjoin', $showbuttonjoin);
    $templater->register('listplayer', $listplayer);
    $templater->register('action', $action);
    $templater->register('checkdone', $checkdone);
    $templater->register('listcheckitem', $listcheckitem);
    $templater->register('getusernamecheck',$getusernamecheck);
    $templater->register('showmanageraccpet',$showmanageraccpet);
    $templater->register('useridcheck',$useridcheck);
    $templater->register('setting4', $setting4);
 	$fshop_managercheck = $templater->render(); 
$titlestart = "Event";


?>