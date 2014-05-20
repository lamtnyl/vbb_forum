<?php
	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$_GET[id]'");   
    $infoitem = $vbulletin->db->fetch_array($query);

                $iditem = $_GET['id'];
                $nameitem = $infoitem['name'];
                $imageitem = $infoitem['image'];
                $amountitem = $infoitem['amount'];
                $timeitem = $infoitem['time'];
                $desitem = $infoitem['des'];
                $golditem = $infoitem['gold'];
                $active = $infoitem['active'];
   if($active==0 || $amountitem==0 || $usermoney < $golditem)
     {
    	eval('standard_error(Error);');    
     }
     
 	$templater = vB_Template::create('fshop_dobuy');
    $templater->register('iditem', $iditem);
    $templater->register('nameitem', $nameitem);
    $templater->register('imageitem', $imageitem);
    $templater->register('amountitem', $amountitem);
    $templater->register('timeitem', $timeitem);
    $templater->register('desitem', $desitem);
    $templater->register('golditem', $golditem);
    $templater->register('setting4', $setting4);
 	$fshop_dobuy = $templater->render(); 
$titlestart = "Select Amounts";


?>