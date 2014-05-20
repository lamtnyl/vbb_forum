<?php
$checkusermanager = explode(",",$setting11);
 if(!in_array($userid,$checkusermanager))
   {
    eval('standard_error(Error);');   
   }

	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser As fshop_eventuser LEFT JOIN " . TABLE_PREFIX . "fshop_event As fshop_event ON(fshop_eventuser.eventid=fshop_event.id) WHERE fshop_eventuser.done!=0 ORDER BY fshop_eventuser.done ASC,fshop_eventuser.date ASC");   
    while($infoevent = $vbulletin->db->fetch_array($query))
     {
    $queryb = $vbulletin->db->query_read("SELECT *,user.usertitle As usertitleevent FROM " . TABLE_PREFIX . "user As user LEFT JOIN " . TABLE_PREFIX . "usergroup As usergroup ON (user.usergroupid=usergroup.usergroupid) WHERE user.userid ='$infoevent[userid]'");   
     $infouser = $vbulletin->db->fetch_array($queryb);  
     if($infoevent['done']==1)
     {
      $sttdone =  "<font color='red'><u>$infoevent[name]</u></font>";
     }elseif($infoevent['done']==2)
     {
     $sttdone =  "<font color='blue'><u>$infoevent[name]</u></font> - [ $vbphrase[fshop_combinemore] ]";   
     }elseif($infoevent['done']==3)
     {
      $sttdone =  "<font color='blue'><u>$infoevent[name]</u></font> - [ <u><i>$vbphrase[fshop_acceptaw]</i></u> ]";   
     }elseif($infoevent['done']==4)
     {
      $sttdone =  "<font color='blue'><u>$infoevent[name]</u></font> - [ <u><i>$vbphrase[fshop_rejectaw]</i></u> ]";   
     }
     $timecombine =  convert_timestamp_to_date($infoevent['date']); 
     $usertitleshow = strip_tags($infouser['usertitleevent']);
$listusercombined .="<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolitem'>
<img class='sgiconjoin' src='$infoevent[image]' width='35px' height='35px' /> 
</div>
<div class='maincol'>
<b>
$vbphrase[fshop_itemevent] : $sttdone<br>
$vbphrase[fshop_usercombine] : <a href='member.php?$infouser[userid]'>$infouser[opentag] $infouser[username] $infouser[closetag]</a> - ( $usertitleshow )<br>
$vbphrase[fshop_timecombine] : $timecombine - [ <a href='fshop.php?do=managercheck&idevent=$infoevent[id]&userid=$infoevent[userid]'>$vbphrase[fshop_checkingitem]</a> ]
</b>
</div>
</li></ul></div>

";   
 }
  $vbulletin->input->clean_array_gpc('r', array(
    'perpage'    => TYPE_UINT,
    'pagenumber' => TYPE_UINT,
));  

$cel_users = $db->query_first("
    SELECT COUNT('id') AS item_count
    FROM " . TABLE_PREFIX . "fshop_eventpost AS fshop_eventpost
");  

sanitize_pageresults($cel_users['item_count'], $pagenumber, $perpage, 100, 10);  
if ($vbulletin->GPC['pagenumber'] < 1)
{
    $vbulletin->GPC['pagenumber'] = 1;
}
else if ($vbulletin->GPC['pagenumber'] > ceil(($cel_users['item_count'] + 1) / $perpage))
{
    $vbulletin->GPC['pagenumber'] = ceil(($cel_users['item_count'] + 1) / $perpage);
}
$limitlower = ($vbulletin->GPC['pagenumber'] - 1) * $perpage;
$limitupper = ($vbulletin->GPC['pagenumber']) * $perpage;  


$pagenav = construct_page_nav(
    $vbulletin->GPC['pagenumber'],
    $perpage,
    $cel_users['item_count'],
    'fshop.php?do=managerevent' . $vbulletin->session->vars['sessionurl']);  

 
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventpost As fshop_eventpost LEFT JOIN " . TABLE_PREFIX . "thread As thread ON(fshop_eventpost.threadid=thread.threadid) ORDER BY fshop_eventpost.date DESC LIMIT $limitlower, $perpage");   
    while($infopost = $vbulletin->db->fetch_array($query))
     {
    $queryb = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid ='$infopost[userid]'");   
     $infouser = $vbulletin->db->fetch_array($queryb);  
    
     $queryc = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id ='$infopost[itemid]'");   
     $infoitem = $vbulletin->db->fetch_array($queryc);  
     $timegot =  convert_timestamp_to_date($infopost['date']); 
$listusergot .="<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolevent'>
<img class='sgiconjoin' src='$infoitem[image]' width='25px' height='25px' /> 
</div>
<div class='maincolevent'>
<b>
$vbphrase[fshop_itemevent] : <font color='red'><u>$infoitem[name]</u></font><br>
* <a href='member.php?$infouser[userid]'>$infouser[opentag] $infouser[username] $infouser[closetag]</a> - <a href='showthread.php?$infopost[threadid]-$infopost[title]&p=$infopost[postid]#post$infopost[postid]'>$infopost[title]</a> - [ $timegot ]<br>

</b>
</div>
</li></ul></div>

";   
 } 
 
 
 
 
 
 
      

   	$templater = vB_Template::create('fshop_managerevent');
    $templater->register('listusercombined', $listusercombined);
    $templater->register('listusergot', $listusergot);
    $templater->register('pagenav', $pagenav);
    $templater->register('pagenumber', $pagenumber);
    $templater->register('perpage', $perpage);
    $templater->register('output', $output);
 	$fshop_managerevent = $templater->render(); 
$titlestart = "MANAGER EVENT";


?>