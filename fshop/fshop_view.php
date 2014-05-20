<?php
 $vbulletin->input->clean_array_gpc('r', array(
    'perpage'    => TYPE_UINT,
    'pagenumber' => TYPE_UINT,
));  

$cel_users = $db->query_first("
    SELECT COUNT('id') AS item_count
    FROM " . TABLE_PREFIX . "fshop_timeleft AS fshop_timeleft
    WHERE userid = '$userid'
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
    'fshop.php?do=view' . $vbulletin->session->vars['sessionurl']);  


 $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft As fshop_timeleft LEFT JOIN " . TABLE_PREFIX . "fshop_items As fshop_items ON(fshop_timeleft.itemid=fshop_items.id)WHERE fshop_timeleft.userid='$userid' ORDER BY fshop_timeleft.id DESC LIMIT $limitlower, $perpage");
    while($row =  $db->fetch_array($query))
    {
        $items[] = array(1 => $row['id'], 2 => $row['name'],3 => $row['image'],4 => $row['timeleft'],5 => $row['timeused'],6 => $row['settingtype'],7=> $row['des'],8=>$row['itemtype']);
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
                $timeleft = convert_timestamp_to_date($items[$cell - 1][4]);
                $timeused = convert_timestamp_to_date($items[$cell - 1][5]);
                $settingitem = explode("||",$items[$cell - 1][6]);
                $desitem = $items[$cell - 1][7];
                $itemtype = $items[$cell - 1][8];
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
	</div>

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
	</div>

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
ITEMS
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
      

   	$templater = vB_Template::create('fshop_view');
    $templater->register('displayitem', $displayitem);
    $templater->register('pagenav', $pagenav);
    $templater->register('pagenumber', $pagenumber);
    $templater->register('perpage', $perpage);
    $templater->register('output', $output);
	$fshop_view = $templater->render(); 
$titlestart = "VIEW";


?>