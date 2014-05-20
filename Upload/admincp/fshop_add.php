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
if ($_GET['add']=="item")
  {
  if($_GET['submit']=="DONE")
{
    $itemname = $_GET['itemname'];
    $itemimg = $_GET['itemimg'];
    $itemdes = $db->escape_string($_GET['itemdes']);
    $itemamount = $_GET['itemamount'];
    $itemtime = $_GET['itemtime'];
    $itemgold = $_GET['itemgold'];
    $itemtypeadd = $_GET['itemtypeadd'];

 $itemtype =$_GET['itemtype'];
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
             
            
$vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_items
				(`name`,
                `itemtype`,
				`image`,
                `amount`,
                `time`,
                `des`,
                `gold`,
                `setting`               
				)
			VALUES
				('$itemname',
                '$itemtype',
				'$itemimg',
                '$itemamount',
                '$itemtime',
                '$itemdes',
                '$itemgold',
                '$savesetting'
			   )
		");    
 
print_cp_message('<b><center>HOÀN TẤT .<br> <br><img src="../fshop/image/loading.gif"></center></b>', 'fshop_items.php',2);  
    }
   elseif($_GET['submit']=="NEXT")
    {
    $idtype = $_GET['itemtype'];
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_itemtype WHERE id='$idtype'");   
    $getnametype = $vbulletin->db->fetch_array($query);
    
    print_cp_header("ADD ITEM");
	echo "<form name='settings' action='fshop_add.php?add=item' method='GET'>";
	print_table_start();
	print_table_header(strtoupper($getnametype['typeitem']));
   
    print_cells_row(array("General Setting ( <u>-1</u> For No Limit)","Value"),1,0,-2);
    print_input_row('Name', 'itemname');
    print_input_row('Image','itemimg','',0,60);
    print_textarea_row('Description', 'itemdes');   
    print_input_row('Amount', 'itemamount','',0,5);  
    print_input_row('Time', 'itemtime','',0,5);  
    print_input_row($setting4, 'itemgold','',0,5);  
   	print_hr_row();  
    
    print_cells_row(array("Special Setting","Value"),1,0,-2);
         if($idtype==1)
      {
    print_input_row('<b>LIMIT CHARACTERS</b>', 'characters',100,0,15);
   	print_yes_no_row('<b>USE WYSIWYG</b>', 'usewys',1);
    print_yes_no_row('Font Size', 'fontsize',1);
    print_yes_no_row('Font Family', 'fontfamily',1);
    print_yes_no_row('Bold', 'bold',1);
    print_yes_no_row('Italic', 'italic',1);
    print_yes_no_row('Underline', 'underline',1);
    print_yes_no_row('Strike Through', 'strikethrough',1);
    print_yes_no_row('Align', 'align',1);
    print_yes_no_row('Link', 'link',1);
    print_yes_no_row('Color', 'color',1);
    print_yes_no_row('Back Color', 'backcolor',1);
     
        }elseif($idtype==2)
      {
       
      	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
          if($getusergroup['usergroupid']==8)
         {
       $listselect .="<option value='$getusergroup[usergroupid]' selected>$getusergroup[title]</option>";  
         }else
         {
          $listselect .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";      
         }
        
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
      
       } 
    
     print_cells_row(array("<b>Usergroups Can't Be Banned</b>","
     <select name='usergroupnoban[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2);
      print_cells_row(array("<b>Move To Group</b>","<select name='groupban'>$listselect</select>"),0,0,-2);
     print_yes_no_row('Show Username', 'showusername',1); 
     print_yes_no_row('Require Message', 'messageban',1);
     print_yes_no_row('Ajax Check Username', 'ajaxcheck',1);
         }
       elseif($idtype==3)
      {
        
    	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
       
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
     
       }     
     print_cells_row(array("<b>Usergroups Can't Be Changed Title</b>","
     <select name='usergroupnotitle[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2); 
    print_input_row('<b>LIMIT CHARACTERS</b>', 'characters',100,0,15);
    print_yes_no_row('<b>Show Username</b>', 'showusername',1);
    print_yes_no_row('<b>Ajax Check</b>', 'ajaxcheck',1);
   	print_yes_no_row('<b>USE WYSIWYG</b>', 'usewys',1);
    print_yes_no_row('Font Size', 'fontsize',1);
    print_yes_no_row('Font Family', 'fontfamily',1);
    print_yes_no_row('Bold', 'bold',1);
    print_yes_no_row('Italic', 'italic',1);
    print_yes_no_row('Underline', 'underline',1);
    print_yes_no_row('Strike Through', 'strikethrough',1);
    print_yes_no_row('Align', 'align',1);
    print_yes_no_row('Link', 'link',1);
    print_yes_no_row('Color', 'color',1);
    print_yes_no_row('Back Color', 'backcolor',1);
     
        }
         elseif($idtype==4)
      {
      
    	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup");   
     while($getusergroup = $vbulletin->db->fetch_array($query))
      {
        
       $listbox .="<option value='$getusergroup[usergroupid]'>$getusergroup[title]</option>";    
     
       }     
     print_cells_row(array("<b>Usergroups Can Be Changed Color</b>","
     <select name='usergroupcolor[]' size='7' multiple='multiple'>
    $listbox</select>"),0,0,-2); 
  
     
        }
           elseif($idtype==5)
      {
    print_yes_no_row('<b>SAME NICK</b>', 'samenick',0);
    print_yes_no_row('Ajax Check', 'ajaxcheck',1);
   
     
        }  
      elseif($idtype==6)
      {
      for($i=0;$i<=6;$i++)
       {
        $k=$i+1;
         $loadeffect .= "<tr><td><input type='checkbox' name='effect$k' checked></td><td><b><div id='fs_rb$k-0'>Effect $k</div></b></td></tr>";
         }
      print_cells_row(array("<b>EFFECT</b><br>( Effect for Title )","<table>
    $loadeffect
      </table>"),0,0,-2);
        }     
   print_table_header("<input type='hidden' name='add' value='item'><input type='hidden' name='itemtype' value='$idtype'><input type='submit' class='button' name='submit' value='DONE'>");
echo "</form>";
 echo "<script src='../fshop/script/effecttext.js'></script>" ;
   print_table_footer();  
	print_cp_footer();
 
    }
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_itemtype");   
    while($gettype = $vbulletin->db->fetch_array($query))
      {
      $listtype .="<option value='$gettype[id]' alt='$gettype[des]'>$gettype[typeitem]</option>";  
      }
    ?>
    <script type="text/javascript">
 function displaydestype(valuetype)
  {
  document.getElementById("hiddestype").style.display = "block";
  document.getElementById("loaddestype").innerHTML = valuetype;
  }
</script>
<?php
    print_cp_header("ADD ITEM");
	echo "<form name='settings' action='fshop_add.php?add=item' method='GET'>";
	print_table_start();
	print_table_header("ADD NEW ITEM");
    print_cells_row(array("<Center>Select Item Type</center>"),1,0,-2);
    print_cells_row(array("<Center><select name='itemtype' id='itemtype' onchange='displaydestype(this.options[this.selectedIndex].alt)'>$listtype</select></center>"));

  	print_description_row('<br>
		<div id="hiddestype" style="border:2px inset;display:none;">	<ul >
        <li>
	   <b><font color="green">
        <div id="loaddestype"></div>
       </font></b>
       </li>
       </ul></div>
	');

		print_table_header("<input type='hidden' name='add' value='item'><input type='submit' name='submit' class='button' value='NEXT'>");
	echo "</form>";
   print_table_footer();  
	print_cp_footer();
  }
  
 
   
?>

