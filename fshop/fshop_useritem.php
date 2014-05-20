<?php
 $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");
 $query =  $vbulletin->db->fetch_array($query);
 $listitems = explode(";",$query['items']);
 $listamounts = explode(";",$query['amountitems']);
 if($listitems[0]=="")
 {
 $notdisplay=1;
 }
 
 $vbulletin->input->clean_array_gpc('r', array(
    'perpage'    => TYPE_UINT,
    'pagenumber' => TYPE_UINT,
));  

$countlist = count($listitems);
$cel_users = $db->query_first("
    SELECT $countlist AS item_count
    FROM " . TABLE_PREFIX . "fshop_user AS fshop_user
    WHERE userid='$userid'");

sanitize_pageresults($cel_users['item_count'], $pagenumber, $perpage, 100, $setting8);  
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
    'fshop.php?do=equip' . $vbulletin->session->vars['sessionurl']);  
  

  $newitemarray = array();
  $newamountarray = array();
    for($adda=1;$adda<=$perpage;$adda++)
      {
       $newitemarray[$adda]=$listitems[$limitlower];
       $newamountarray[$adda-1]=$listamounts[$limitlower++];
      }
   $counti=0;  
 foreach($newitemarray As $i)
   {
    
  $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$i' AND active=1 ");
  $row =  $db->fetch_array($query);
  $items[] = array(1 => $row['id'], 2 => $row['name'],3 => $row['image'],4 => $newamountarray[$counti],5 => $row['time'],6 => $row['des']);
    
   $counti++; 
    
   }
  
   
        $numcols = $setting7;
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
                $amountitem = $items[$cell - 1][4];
                $timeitem = $items[$cell - 1][5];
                $desitem = $items[$cell - 1][6];
               
         
            
      $linkuse = "[ <A href='fshop.php?do=use&id=$iditem'><i>$vbphrase[fshop_using]</i></a> ]";     
      
         if($amountitem==-1)
           {
          $amountitem="$vbphrase[fshop_nolimitamount]";  
           }
           if($timeitem==-1)
           {
          $timeitem="$vbphrase[fshop_nolimittime]"; 
           }      
            if($iditem)
              {
                 $displayitem .="	<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='fshop/image/youritem.png' alt='' />
$nameitem - $linkuse
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$vbphrase[fshop_amount] : $amountitem<bR>
$vbphrase[fshop_time] : $timeitem <bR>
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
                $amountitem = $items[$cell - 1][4];
                $timeitem = $items[$cell - 1][5];
                $desitem = $items[$cell - 1][6];
            
            
    $linkuse = "[ <A href='fshop.php?do=use&id=$iditem'><i>$vbphrase[fshop_using]</i></a> ]";     
      
         if($amountitem==-1)
           {
          $amountitem="$vbphrase[fshop_nolimitamount]";  
           }
           if($timeitem==-1)
           {
          $timeitem="$vbphrase[fshop_nolimittime]"; 
           }      
            if($iditem)
              {
                 $displayitem .="	<div id='mygroups' class='block'>
					<h2 class='blockhead'>
					<img src='fshop/image/youritem.png' alt='' />
$nameitem - $linkuse
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$vbphrase[fshop_amount] : $amountitem<bR>
$vbphrase[fshop_time] : $timeitem <bR>
</b>
<hr>
<p class='description'>
$desitem
</p>
			</div></li></ul></div></div>
	</div>

";}}
            $displayitem .='  </td>'."\n";
            }
            $displayitem .= ' </tr>'."\n";
        
        }
         $displayitem .= '</table>';
if($notdisplay==1)
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

   	$templater = vB_Template::create('fshop_useritem');
    $templater->register('displayitem', $displayitem);
    $templater->register('pagenav', $pagenav);
    $templater->register('pagenumber', $pagenumber);
    $templater->register('perpage', $perpage);
    $templater->register('output', $output);
	$fshop_useritem = $templater->render(); 
$titlestart = "YOUR ITEMS";


?>