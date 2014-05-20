<?php
 $vbulletin->input->clean_array_gpc('r', array(
    'perpage'    => TYPE_UINT,
    'pagenumber' => TYPE_UINT,
));  

$cel_users = $db->query_first("
    SELECT COUNT('id') AS item_count
    FROM " . TABLE_PREFIX . "fshop_items AS fshop_items
    WHERE active = '1'
");  

sanitize_pageresults($cel_users['item_count'], $pagenumber, $perpage, 100, $setting6);  
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
    'fshop.php?' . $vbulletin->session->vars['sessionurl']);  


 $query =  $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE active=1 ORDER BY id DESC LIMIT $limitlower, $perpage");
    while($row =  $db->fetch_array($query))
    {
        $items[] = array(1 => $row['id'], 2 => $row['name'],3 => $row['image'],4 => $row['amount'],5 => $row['time'],6 => $row['des'],7 => $row['gold']);
    }
   
        $numcols = $setting5;
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
                $golditem = $items[$cell - 1][7];
         
            if($amountitem==0)
       {
       $linkbuy = "[ $vbphrase[soldout] ]";
       }
      elseif($usermoney < $golditem)
       {
      $linkbuy = "[ $vbphrase[fshop_notenough] $setting4 ]";  
       }else
       {
      $linkbuy = "[ <A href='fshop.php?do=buy&id=$iditem'><i>$vbphrase[fshop_dobuy]</i></a> ]";     
       }  
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
					<img src='images/misc/star.png' alt='' />
$nameitem - $linkbuy
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$setting4 : $golditem<br>
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
                $golditem = $items[$cell - 1][7];
            
            if($amountitem==0)
       {
       $linkbuy = "[ $vbphrase[soldout] ]";
       }
      elseif($usermoney < $golditem)
       {
      $linkbuy = "[ $vbphrase[fshop_notenough] $setting4 ]";  
       }else
       {
      $linkbuy = "[ <A href='fshop.php?do=buy&id=$iditem'><i>$vbphrase[fshop_dobuy]</i></a> ]";     
       }  
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
					<img src='images/misc/star.png' alt='' />
$nameitem - $linkbuy
	</h2>
					<div class='blockbody'>
						<ul class='blockrow'>
					
<li class='sgicon floatcontainer'>

	<div class='leftcol'>
<img class='sgicon' src='$imageitem' /> 
       </div>
<div class='maincol'>
<b>
$setting4 : $golditem<br>
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


   	$templater = vB_Template::create('fshop_buy');
    $templater->register('displayitem', $displayitem);
    $templater->register('pagenav', $pagenav);
    $templater->register('pagenumber', $pagenumber);
    $templater->register('perpage', $perpage);
    $templater->register('output', $output);
	$fshop_buy = $templater->render(); 
$titlestart = "SHOP";


?>