<?php
 $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser As fshop_eventuser LEFT JOIN " . TABLE_PREFIX . "fshop_event As fshop_event ON(fshop_eventuser.eventid=fshop_event.id) WHERE fshop_eventuser.userid='$userid' ORDER BY fshop_eventuser.id DESC");
 while($showinfo =  $db->fetch_array($query))
  {
  $timeend = convert_timestamp_to_date($showinfo['timeend']);
  $timestart = convert_timestamp_to_date($showinfo['timestart']);
  if($showinfo['players']==-1)
  {
  $showinfo['phayers']="No Limit";  
  }
  $displayeventjoined .="<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='images/misc/star.png' alt='' />
$showinfo[name] - [ <i><a href='fshop.php?do=eventid&id=$showinfo[id]'><font color='yellow'><u>$vbphrase[fshop_checkingevent]</u></font></a></i> ]
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$showinfo[image]' /> 
       </div>
<div class='maincol'>
<b>
$vbphrase[fshop_timeend]  : <font color='red'>$timeend</font><br>
$vbphrase[fshop_timestart] : $timestart<bR>
$vbphrase[fshop_playerevent] : $showinfo[phayers]<bR>
$vbphrase[fshop_award] : <font color='blue'>$showinfo[award]</font><bR>
$vbphrase[fshop_gjoin] : <i>$showinfo[gold] $setting4</i><br>
</b>
<hr>
<p class='description'>
$showinfo[des]
</p>
			</div></li></ul></div></div>
<hr>

";
}

 $vbulletin->input->clean_array_gpc('r', array(
    'perpage'    => TYPE_UINT,
    'pagenumber' => TYPE_UINT,
));  

$cel_users = $db->query_first("
    SELECT COUNT('id') AS item_count
    FROM " . TABLE_PREFIX . "fshop_event AS fshop_event
    WHERE active='1'
");  

sanitize_pageresults($cel_users['item_count'], $pagenumber, $perpage, 100, $setting10);  
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
    'fshop.php?do=event' . $vbulletin->session->vars['sessionurl']);  


 $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE active='1' ORDER BY id DESC LIMIT $limitlower, $perpage");
    while($row =  $db->fetch_array($query))
    {
        $items[] = array(1 => $row['id'], 2 => $row['name'],3 => $row['image'],4 => $row['des'], 5 => $row['timeend'],6 => $row['timestart'],7 => $row['players'],8 => $row['award'],9 => $row['gold']);
    }
    
        $numcols = $setting9;
         $numitems = count($items);
          $numrows = ceil($numitems/$numcols);
           $displayitem =  '<table width="100%">';
        for ($row=1; $row <= $numrows; $row++)
        {
            $cell = 0;
           $displayitem .= ' <tr>'."\n";
            for ($col=1; $col <= $numcols; $col++)
            {
           $displayitem .= '  <td width="'.round(100/$numcols).'%" valign=top>'."\n";
            if ($col===1)
            {
                $cell += $row;
                $iditem = $items[$cell - 1][1];
                $nameitem = $items[$cell - 1][2];
                $imageitem = $items[$cell - 1][3];
                $desitem = $items[$cell - 1][4];
                $timeend = convert_timestamp_to_date($items[$cell - 1][5]);
                $timestart = convert_timestamp_to_date($items[$cell - 1][6]);
                $players = $items[$cell - 1][7];
                $fsaward = $items[$cell - 1][8];
                $goldevent = $items[$cell - 1][9];
                if($players==-1)
  {
  $players="No Limit";  
  }
                        if($iditem)
              {
                 $displayitem .="	<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='images/misc/star.png' alt='' />
$nameitem - [ <i><a href='fshop.php?do=eventid&id=$iditem'>$vbphrase[fshop_viewdetail]</a></i> ]
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$vbphrase[fshop_timeend]  : <font color='red'>$timeend</font><br>
$vbphrase[fshop_timestart] : $timestart<bR>
$vbphrase[fshop_playerevent] : $players<bR>
$vbphrase[fshop_award] : <font color='blue'>$fsaward</font><bR>
$vbphrase[fshop_gjoin] : <i>$goldevent $setting4</i><br>
</b>
<hr>
<p class='description'>
$desitem
</p>
			</div></li></ul></div></div>


";
                 }  }
          
            else {
             $cell += $numrows;
             $iditem = $items[$cell - 1][1];
                $nameitem = $items[$cell - 1][2];
                $imageitem = $items[$cell - 1][3];
                $timeleft = convert_timestamp_to_date($items[$cell - 1][4]);
                $timeused = convert_timestamp_to_date($items[$cell - 1][5]);
                $settingitem = explode(";",$items[$cell - 1][6]);
                $desitem = $items[$cell - 1][7];
                $itemtype = $items[$cell - 1][8];
                  if($players==-1)
  {
  $players="No Limit";  
  }
              if($itemtype==1)
                 {
                 $info  = "<div style='float:left'>$vbphrase[fshop_oldtitle] : &nbsp;</div> <div style='float:left'>$settingitem[0]</div>";   
                 }elseif($itemtype==2)
                 {
                 $info = "<div style='float:left'>$vbphrase[fshop_userban] : &nbsp;</div> <div style='float:left'>$settingitem[0]</div>";   
                 }
                elseif($itemtype==3)
                 {
                $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid='$settingitem[0]'");   
                $getinfo = $vbulletin->db->fetch_array($query);
                 $info = "<div style='float:left'>$vbphrase[fshop_username] : $getinfo[username] -- $vbphrase[fshop_oldtitle] : &nbsp;</div> <div style='float:left'>$settingitem[1]</div>";   
                 }
                elseif($itemtype==4)
                 {
                $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup WHERE usergroupid='$settingitem[0]'");   
                $getinfo = $vbulletin->db->fetch_array($query);
                 $info = "<div style='float:left'>$vbphrase[fshop_oldusergroup] : $getinfo[title]</div>";   
                 }
                  elseif($itemtype==5)
                 {
                $info = "<div style='float:left'>$vbphrase[fshop_oldusername] : $settingitem[0]</div>";   
                 } 
                  elseif($itemtype==6)
                 {
                $info = "<div style='float:left'>$vbphrase[fshop_effect] : $settingitem[0]</div>";   
                 }  
               if($iditem)
              {
                 $displayitem .="	<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='images/misc/star.png' alt='' />
$nameitem - [ <i><a href='fshop.php?do=request&doit=resetitem&id=$iditem'>$vbphrase[fshop_reset]</a></i> ]
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$vbphrase[fshop_timeleft]  : <font color='red'>$timeleft</font><br>
$vbphrase[fshop_timeused] : $timeused<bR>
$info
<br clear='both'>
</b>
<hr>
<p class='description'>
$desitem
</p>
			</div></li></ul></div></div>


";
}}
            $displayitem .='  </td>'."\n";
            }
            $displayitem .= ' </tr>'."\n";
        
        }
         $displayitem .= '</table>';
     
     if($numitems==0)
       {
        $displayitem ="	<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='fshop/image/youritem.png' alt='' />
EVENTS
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div>
    <br>
<Center><B>$vbphrase[fshop_notavailableitem]</b></center>
<br>
			</div></li></ul></div></div>
	"; 
    }
      

   	$templater = vB_Template::create('fshop_event');
    $templater->register('displayitem', $displayitem);
    $templater->register('displayeventjoined', $displayeventjoined);
    $templater->register('pagenav', $pagenav);
    $templater->register('pagenumber', $pagenumber);
    $templater->register('perpage', $perpage);
    $templater->register('output', $output);
	$fshop_event = $templater->render(); 
$titlestart = "EVENT";


?>