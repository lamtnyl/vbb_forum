<?php
 $getitem = $_GET['id'];
 	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$getitem'");   
    $infoitem = $vbulletin->db->fetch_array($query);

                $iditem = $_GET['id'];
                $nameitem = $infoitem['name'];
                $imageitem = $infoitem['image'];
                $timeitem = $infoitem['time'];
                $desitem = $infoitem['des'];
                $active = $infoitem['active'];
                $itemtype = $infoitem['itemtype'];
  
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");   
   $checking = $vbulletin->db->fetch_array($query); 
   $listitems = explode(";",$checking['items']) ;           
   $listamounts = explode(";",$checking['amountitems']) ;    
              
   if($active==0 || !in_array($getitem,$listitems))
     {
    	eval('standard_error(Error);');    
     }
    $keyitem = array_search($getitem,$listitems) ;
   $amountitem = $listamounts[$keyitem];
   $settingitem = $infoitem['setting'];  
   switch ($itemtype) {
    case 1:
      include("fshop/itemtype/itemid1.php");
      break;
    case 2:
      include("fshop/itemtype/itemid2.php");
      break; 
    case 3:
      include("fshop/itemtype/itemid3.php");
      break;   
    case 4:
      include("fshop/itemtype/itemid4.php");
      break;  
    case 5:
      include("fshop/itemtype/itemid5.php");
      break;
    case 6:
      include("fshop/itemtype/itemid6.php");
      break;    
}
	$templater = vB_Template::create('fshop_use');
    $templater->register('displayusing', $displayusing);
    $templater->register('iditem', $iditem);
    $templater->register('itemtype', $itemtype);
    $templater->register('nameitem', $nameitem);
    $templater->register('imageitem', $imageitem);
    $templater->register('amountitem', $amountitem);
    $templater->register('timeitem', $timeitem);
    $templater->register('desitem', $desitem);
    $templater->register('setting4', $setting4);
 	$fshop_use = $templater->render(); 
$titlestart = "Use Item";


?>