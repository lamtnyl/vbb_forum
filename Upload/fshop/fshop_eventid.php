<?php
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$_GET[id]'");   
    $infoevent = $vbulletin->db->fetch_array($query);

                $idevent = $_GET['id'];
                $nameevent = $infoevent['name'];
                $imageevent = $infoevent['image'];
                $desevent = $infoevent['des'];
                $timestart =  convert_timestamp_to_date($infoevent['timestart']);
                $timeend =  convert_timestamp_to_date($infoevent['timeend']);
                $players = $infoevent['players'];
                $fsaward = $infoevent['award'];
                $goldevent = $infoevent['gold'];
                $playerjoin = explode(",",$infoevent['playerjoin']);
                $countplayerjoin = count($playerjoin);
                $itemlist = explode(",",$infoevent['itemrequire']);
                $active = $infoevent['active'];
   if($active==0)
     {
    	eval('standard_error(Error);');    
     }
   $showbuttonjoin=1;
   if($playerjoin[0]=="")
    {
    $countplayerjoin=0;    
    }
   if($players==-1)
    {
     $players= "No Limit";   
    }
 if(in_array($userid,$playerjoin))
   {
    $showbuttonjoin =0;
    }
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$userid' AND eventid='$idevent'");   
   $infocollect = $vbulletin->db->fetch_array($query); 
   $checkdone = $infocollect['done'];
   $fetchitem = explode(";",$infocollect['collect']);
   $getitem = array();
   $getamount = array();
   for($i=0;$i<count($fetchitem);$i++)
     {
     $fetchamount = explode("-",$fetchitem[$i]);  
     $getitem[]= $fetchamount[0] ;
     $getamount[]= $fetchamount[1] ;
     }
   
    $showcollect = $vbphrase['fshop_itemcollect'] ." : ";
   

if($itemlist[0]!==0)
 {
   $key_search = array(); 
  foreach($itemlist As $i)  
  {
    
   $key_search = array_search($i,$getitem);
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$i'");   
   $infoitem = $vbulletin->db->fetch_array($query);
    if(in_array($i,$getitem))
    {
   $getamountitem = $getamount[$key_search];  
   }else
   {
   $getamountitem =0; 
   }
   
   if(!$getamountitem)
   {
    $getamountitem=0;
   }
   if($getamountitem >= $infoitem['requiream'])
   {
   $showcollecta = "<font color='blue'><i>$showcollect <u>$getamountitem</u> </i></font> <br> <Center>[ <i><u>Done</u></i> ]</center>";
   }elseif($showbuttonjoin==0)
   {
  $showcollecta = "$showcollect <u>$getamountitem</u>";  
   }

$listeventitem .="<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolitem'>
<img class='sgiconevent' src='$infoitem[image]' /> 
</div>
<div class='maincol'>
<b>
$vbphrase[fshop_itemevent] : <font color='red'>$infoitem[name]</font><br>
$vbphrase[fshop_itemrequire] : <u>$infoitem[requiream]</u><br>
$showcollecta
</b>
</div>
</li></ul></div>";
}}
$action = $_GET['action'];
 if($action=="check")
 {
    $listshow = array();
      foreach($itemlist As $i)  
  {
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$i'");   
   $infoitem = $vbulletin->db->fetch_array($query);
$k=1;   
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventpost As fshop_eventpost LEFT JOIN " . TABLE_PREFIX . "thread As thread ON(fshop_eventpost.threadid=thread.threadid) WHERE fshop_eventpost.userid='$userid' AND fshop_eventpost.eventid='$idevent' AND fshop_eventpost.itemid='$i'");   
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
$vbphrase[fshop_itemevent] : <font color='red'>$infoitem[name]</font><br>
$listshow[$i]


</b>
</div>
</li></ul></div>";
    }
 }else
 {
if($playerjoin[0]==0)
  {
  $listplayer = "<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='maincol'>
<b>
$vbphrase[fshop_notplayerjoin]
</b>
</div>
</li></ul></div>";
  } else
  {
  
   foreach($playerjoin As $i)
   {
 	$query = $vbulletin->db->query_read("SELECT *,user.usertitle As usertitleevent FROM " . TABLE_PREFIX . "user As user LEFT JOIN " . TABLE_PREFIX . "usergroup As usergroup ON (user.usergroupid=usergroup.usergroupid) WHERE user.userid =$i");   
   $row =  $db->fetch_array($query);
   $items[] = array(1 => $row['userid'], 2 => $row['username'],3 => $row['opentag'],4 => $row['closetag'],5 => $row['usertitleevent']);
  
  $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$i' AND eventid='$idevent'");   
   $showdone = $vbulletin->db->fetch_array($query);
    if($showdone['done']==1 || $showdone['done']==3 || $showdone['done']==4)
     {
     $showdoneuser[$i] = "- [ <i><u><font color='red'>Done</font></u></i> ]";   
     }
   elseif($showdone['done']==2)
     {
     $showdoneuser[$i] = "- [ <font color='red'>$vbphrase[fshop_tolate]</font> ]";   
     }
   }
     
        $numcols = 2;
       $numitems = count($items);
         $numrows = ceil($numitems/$numcols);
                 $listplayer =  '<table width="100%" >';
        for ($row=1; $row <= $numrows; $row++)
        {
            $cell = 0;
           $listplayer .= ' <tr >'."\n";
            for ($col=1; $col <= $numcols; $col++)
            {
           $listplayer .= '  <td width="'.round(100/$numcols).'%" valign=top >'."\n";
            if ($col===1)
            {

                $cell += $row;
                $useridevent = $items[$cell - 1][1];
                $usernameevent = $items[$cell - 1][2];
                $opentag = $items[$cell - 1][3];
                $closetag = $items[$cell - 1][4];
                $usertitleevent = strip_tags(html_cut($items[$cell - 1][5],20));
                $getavatar = fetch_avatar_url($useridevent);
    $getavatar = @$getavatar[0];
     if (empty($getavatar)) 
    {
    $getavatar = 'images/misc/unknown.gif';
    }
             
                if($useridevent)
              {
                 $listplayer .="<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolevent'>
<img class='sgiconjoin' src='$getavatar' width='25px' height='25px' /> 
</div>
<div class='maincolevent'>
<b>
<a href='member.php?$useridevent'>$opentag $usernameevent $closetag </a> $showdoneuser[$useridevent] <br><i>( $usertitleevent )</i>
</b>
</div>
</li></ul></div>

";
                 }  }
          
            else {
             $cell += $numrows;
               $useridevent = $items[$cell - 1][1];
                $usernameevent = $items[$cell - 1][2];
                $opentag = $items[$cell - 1][3];
                $closetag = $items[$cell - 1][4];
               $usertitleevent = strip_tags(html_cut($items[$cell - 1][5],20));
       $getavatar = fetch_avatar_url($useridevent);
    $getavatar = @$getavatar[0];
     if (empty($getavatar)) 
    {
    $getavatar = 'images/misc/unknown.gif';
    }
    
         if($useridevent)
              {
                 $listplayer .="<div class='blockbody'>
<ul class='blockrow'>
<li class='sgicon floatcontainer'>
<div class='leftcolevent'>
<img class='sgiconjoin' src='$getavatar' width='25px' height='25px' /> 
</div>
<div class='maincolevent'>
<b>
<a href='member.php?$useridevent'>$opentag $usernameevent $closetag </a> $showdoneuser[$useridevent]<br><i>( $usertitleevent )</i>
</b>
</div>
</li></ul></div>

";
}}
            $listplayer .='  </td>'."\n";
            }
            $listplayer .= ' </tr>'."\n";
        
        }
         $listplayer .= '</table>';


  }  }
if($itemlist[0]=="")
 {
   $listeventitem=""; 
 }
 	$templater = vB_Template::create('fshop_eventid');
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
    $templater->register('countplayerjoin', $countplayerjoin);
    $templater->register('listplayer', $listplayer);
    $templater->register('action', $action);
    $templater->register('listcheckitem', $listcheckitem);
    $templater->register('checkdone', $checkdone);
    $templater->register('setting4', $setting4);
 	$fshop_eventid = $templater->render(); 
$titlestart = "Event";


?>