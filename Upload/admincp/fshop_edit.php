<?php
error_reporting(E_ALL & ~E_NOTICE);
define('CVS_REVISION', '$RCSfile$ - $Revision: 34940 $');
define('NOZIP', 1);

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('style');
$specialtemplates = array('products');
 
// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/fshop/fshop_setting.php');
$setting4=setting(4);
if (!can_administer('canadminlanguages'))
{
	print_cp_no_permission();
}
if ($_GET['do']=="item")
  {
  if($_GET['submit']=="DELETE")
{
    $id = $_GET['itemid'];
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_items WHERE id='$id'");    
 print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_items.php',2);  
 
}

 elseif($_GET['submit']=="DONE")
{
   
    $id = $_GET['itemid'];
    $itemname = $_GET['itemname'];
    $itemimg = $_GET['itemimg'];
    $itemdes = $db->escape_string($_GET['itemdes']);
    $itemamount = $_GET['itemamount'];
    $itemtime = $_GET['itemtime'];
    $itemgold = $_GET['itemgold'];
    $itemactive = $_GET['active'];
    
  	$db->query("UPDATE  " . TABLE_PREFIX . "fshop_items SET name = '$itemname',image = '$itemimg',des = '$itemdes',amount = '$itemamount',time = '$itemtime',gold = '$itemgold',active='$itemactive' WHERE id='$id'"); 
    $itemtype=$_GET['itemtype'];
    if($itemtype==1)
       {
    $usewys = $_GET['usewys']  ;  
    $fontsize = $_GET['fontsize']  ;
    $fontfamily = $_GET['fontfamily']  ;
    $bold = $_GET['bold']  ;
    $italic = $_GET['italic']  ;
    $underline = $_GET['underline']  ;
    $strikethrough = $_GET['strikethrough']  ;
    $align = $_GET['align']  ;
    $link = $_GET['link']  ;
    $color = $_GET['color']  ;
    $backcolor = $_GET['backcolor']  ;
    $characters = $_GET['characters']  ;
  $addsetting = array($usewys,$fontsize,$fontfamily,$bold,$italic,$underline,$strikethrough,$align,$link,$color,$backcolor,$characters); 

       }	
    elseif($itemtype==2)
    {
    $usergroupnoban = $_GET['usergroupnoban'];
    $savelistnoban = implode(";",$usergroupnoban);
    $showusername = $_GET['showusername'];
    $messageban = $_GET['messageban'];
    $ajaxcheck = $_GET['ajaxcheck'];
    $groupban = $_GET['groupban'];
   $addsetting = array($savelistnoban,$showusername,$messageban,$ajaxcheck,$groupban); 
   
    }elseif($itemtype==3)
    {
    $usewys = $_GET['usewys']  ;  
    $fontsize = $_GET['fontsize']  ;
    $fontfamily = $_GET['fontfamily']  ;
    $bold = $_GET['bold']  ;
    $italic = $_GET['italic']  ;
    $underline = $_GET['underline']  ;
    $strikethrough = $_GET['strikethrough']  ;
    $align = $_GET['align']  ;
    $link = $_GET['link']  ;
    $color = $_GET['color']  ;
    $backcolor = $_GET['backcolor']  ;
    $characters = $_GET['characters']  ;
    $showusername = $_GET['showusername'];
    $usergroupnotitle = $_GET['usergroupnotitle'];
    $savelistnotitle = implode(";",$usergroupnotitle);
    $ajaxcheck = $_GET['ajaxcheck'];
  $addsetting = array($usewys,$fontsize,$fontfamily,$bold,$italic,$underline,$strikethrough,$align,$link,$color,$backcolor,$characters,$showusername,$ajaxcheck,$savelistnotitle); 
      
    }
    elseif($itemtype==4)
    {
    $usergroupcolor = $_GET['usergroupcolor'];
    $savelistcolor = implode(";",$usergroupcolor);
    $addsetting = array($savelistcolor); 
      
    }
     elseif($itemtype==5)
    {
    $samenick = $_GET['samenick'];
    $ajaxcheck = $_GET['ajaxcheck'];
    $addsetting = array($samenick,$ajaxcheck); 
      
    }
         elseif($itemtype==6)
    {
    $effect1 = $_GET['effect1'];
    $effect2 = $_GET['effect2'];
    $effect3 = $_GET['effect3'];
    $effect4 = $_GET['effect4'];
    $effect5 = $_GET['effect5'];
    $effect6 = $_GET['effect6'];
    $effect7 = $_GET['effect7'];
    $addsetting = array($effect1,$effect2,$effect3,$effect4,$effect5,$effect6,$effect7); 
      
    }
    $savesetting = implode(",",$addsetting); 
   $db->query("UPDATE  " . TABLE_PREFIX . "fshop_items SET setting='$savesetting' WHERE id='$id'");      
 print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_items.php',2);  
    }
   
    $id = $_GET['id'];
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$id'");   
    $infoitem = $vbulletin->db->fetch_array($query);
    $idtype = $infoitem['itemtype'];
    print_cp_header("EDIT ITEM");
	echo "<form name='edititems' action='fshop_edit.php?do=item' method='GET'>";
	print_table_start();
	print_table_header(strtoupper($getnametype['typeitem']));
   
    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
	print_yes_no_row('<b>ACTIVE ITEM</b>', 'active',$infoitem['active']);  
    print_input_row('Name', 'itemname',$infoitem['name']);
    print_input_row('Image','itemimg',$infoitem['image'],0,60);
    print_textarea_row('Description', 'itemdes',$infoitem['des']);   
    print_input_row('Amount', 'itemamount',$infoitem['amount'],0,5);  
    print_input_row('Time', 'itemtime',$infoitem['time'],0,5);  
    print_input_row($setting4, 'itemgold',$infoitem['gold'],0,5);  
   	print_hr_row();  
    
    print_cells_row(array("Special Setting","Value"),1,0,-2);
        $specialitem = explode(",",$infoitem['setting'])  ;
         if($idtype==1)
      {
    print_input_row('<b>LIMIT CHARACTERS</b>', 'characters',$specialitem[11],0,15);
   	print_yes_no_row('<b>USE WYSIWYG</b>', 'usewys',$specialitem[0]);
    print_yes_no_row('Font Size', 'fontsize',$specialitem[1]);
    print_yes_no_row('Font Family', 'fontfamily',$specialitem[2]);
    print_yes_no_row('Bold', 'bold',$specialitem[3]);
    print_yes_no_row('Italic', 'italic',$specialitem[4]);
    print_yes_no_row('Underline', 'underline',$specialitem[5]);
    print_yes_no_row('Strike Through', 'strikethrough',$specialitem[6]);
    print_yes_no_row('Align', 'align',$specialitem[7]);
    print_yes_no_row('Link', 'link',$specialitem[8]);
    print_yes_no_row('Color', 'color',$specialitem[9]);
    print_yes_no_row('Back Color', 'backcolor',$specialitem[10]);
     
        }elseif($idtype==2)
      {
          $fetchlistnoban = explode(";",$specialitem[0]);
      	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
          if($specialitem[4]==$getusergroup['usergroupid'])
         {
       $listselect .="<option value='$getusergroup[usergroupid]' selected>$getusergroup[title]</option>";  
         }else
         {
          $listselect .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";      
         }
        if(in_array($getusergroup['usergroupid'],$fetchlistnoban))
        {
       $listbox .="<option value='$getusergroup[usergroupid]' selected >$getusergroup[title]</option>";  
      }else
      {
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
      }
       } 
    
     print_cells_row(array("<b>Usergroups Can't Be Banned</b>","
     <select name='usergroupnoban[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2);
      print_cells_row(array("<b>Move To Group</b>","<select name='groupban'>$listselect</select>"),0,0,-2);
     print_yes_no_row('Show Username', 'showusername',$specialitem[1]); 
     print_yes_no_row('Require Message', 'messageban',$specialitem[2]);
     print_yes_no_row('Ajax Check Username', 'ajaxcheck',$specialitem[3]);
         }
       elseif($idtype==3)
      {
        $fetchlistnotitle = explode(";",$specialitem[14]); 
    	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
          if($specialitem[14]==$getusergroup['usergroupid'])
         {
       $listselect .="<option value='$getusergroup[usergroupid]' selected>$getusergroup[title]</option>";  
         }else
         {
          $listselect .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";      
         }
        if(in_array($getusergroup['usergroupid'],$fetchlistnotitle))
        {
       $listbox .="<option value='$getusergroup[usergroupid]' selected >$getusergroup[title]</option>";  
      }else
      {
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
      }
       }     
     print_cells_row(array("<b>Usergroups Can't Be Changed Title</b>","
     <select name='usergroupnotitle[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2); 
    print_input_row('<b>LIMIT CHARACTERS</b>', 'characters',$specialitem[11],0,15);
    print_yes_no_row('<b>Show Username</b>', 'showusername',$specialitem[12]);
    print_yes_no_row('<b>Ajax Check</b>', 'ajaxcheck',$specialitem[13]);
   	print_yes_no_row('<b>USE WYSIWYG</b>', 'usewys',$specialitem[0]);
    print_yes_no_row('Font Size', 'fontsize',$specialitem[1]);
    print_yes_no_row('Font Family', 'fontfamily',$specialitem[2]);
    print_yes_no_row('Bold', 'bold',$specialitem[3]);
    print_yes_no_row('Italic', 'italic',$specialitem[4]);
    print_yes_no_row('Underline', 'underline',$specialitem[5]);
    print_yes_no_row('Strike Through', 'strikethrough',$specialitem[6]);
    print_yes_no_row('Align', 'align',$specialitem[7]);
    print_yes_no_row('Link', 'link',$specialitem[8]);
    print_yes_no_row('Color', 'color',$specialitem[9]);
    print_yes_no_row('Back Color', 'backcolor',$specialitem[10]);
     
        }
         elseif($idtype==4)
      {
        $fetchlistcolor = explode(";",$specialitem[0]); 
    	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
          if($specialitem[0]==$getusergroup['usergroupid'])
         {
       $listselect .="<option value='$getusergroup[usergroupid]' selected>$getusergroup[title]</option>";  
         }else
         {
          $listselect .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";      
         }
        if(in_array($getusergroup['usergroupid'],$fetchlistcolor))
        {
       $listbox .="<option value='$getusergroup[usergroupid]' selected >$getusergroup[title]</option>";  
      }else
      {
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
      }
       }     
     print_cells_row(array("<b>Usergroups Can Be Changed Color</b>","
     <select name='usergroupcolor[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2); 
  
     
        }
           elseif($idtype==5)
      {
    print_yes_no_row('<b>SAME NICK</b>', 'samenick',$specialitem[0]);
    print_yes_no_row('Ajax Check', 'ajaxcheck',$specialitem[1]);
   
     
        }  
             elseif($idtype==6)
      {
      for($i=0;$i<=6;$i++)
       {
        $k=$i+1;
        if($specialitem[$i]=="on")
         {
         $loadeffect .= "<tr><td><input type='checkbox' name='effect$k' checked></td><td><div id='fs_rb$k-0'>Effect $k</div></td></tr>";
         }else
         {
        $loadeffect .= "<tr><td><input type='checkbox' name='effect$k'></td><td><div id='fs_rb$k-0'>Effect $k</div></td></tr>";
       
         } 
       }
        
     print_cells_row(array("<b>EFFECT</b><br>( Effect for Title )","<table>
    $loadeffect
      </table>"),0,0,-2);
        }     
      
      
   print_table_header("<input type='hidden' name='do' value='item'><input type='hidden' name='itemtype' value='$idtype'><input type='hidden' name='itemid' value='$id'><input type='submit' class='button' name='submit' value='DONE'> - <input type='reset' class='button' name='submit' value='RESET'> - <input type='submit' class='button' name='submit' value='DELETE'>");
	echo "</form>";
   echo "<script src='../fshop/script/effecttext.js'></script>" ;
   print_table_footer();  
	print_cp_footer();
 
    
  }
   
?>



