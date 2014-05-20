<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache'); 
$cwd = (substr(PHP_OS, 0, 3) == 'WIN') ? strtolower(getcwd()) : getcwd(); 
$vwd = str_replace("loadajax.php","",$_SERVER['SCRIPT_FILENAME']);
$vwd = str_replace("fshop","",$vwd);  
chdir($vwd);
require_once($vwd."/global.php");
require_once($vwd."fshop/fshop_setting.php");
chdir($cwd);

 $vbulletin->input->clean_array_gpc('p', array(
    'username'    => TYPE_STR
  
));  
$gettype= $_POST['itemtype'];
$username =  $db->escape_string($_POST['username']);
$itemid = $_POST['itemid'];
   if($gettype==2)
    {
  $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$username'");   
 $checking = $vbulletin->db->fetch_array($query); 
     if($checking['userid'])
       {
         $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "userban WHERE userid='$checking[userid]'");   
        $checkingbanon = $vbulletin->db->fetch_array($query); 
                                    
           $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
           $checkinggroup = $vbulletin->db->fetch_array($query);
          $groupnoban = explode(",",$checkinggroup['setting']);
          $fetchgroupnoban = explode(";",$groupnoban[0])  ;
                                if(in_array($checking['usergroupid'],$fetchgroupnoban) || $checkingbanon['userid'])      
                                    {
                                 $display ="<img src='./fshop/image/stop.png'>";    
                                    }
                                      else
                                     {      
                                 $display ="<img src='./fshop/image/tick.png'>"; 
                                    }
       }else
       {
       $display ="<img src='./fshop/image/cross.png'>";  
       }
     
    }elseif($gettype==3)
     {
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$username'");   
 $checking = $vbulletin->db->fetch_array($query); 
     if($checking['userid'])
       {
           $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
           $checkinggroup = $vbulletin->db->fetch_array($query);
          $groupnotitle = explode(",",$checkinggroup['setting']);
          $fetchgroupnotitle= explode(";",$groupnotitle[14])  ;
                                if(in_array($checking['usergroupid'],$fetchgroupnotitle) || checkitemtitleon($checking['userid']))      
                                    {
                                 $display ="<img src='./fshop/image/stop.png'>";    
                                    }else
                             {      
   
                             $display ="<img src='./fshop/image/tick.png'>"; 
                               }
       }else
       {
       $display ="<img src='./fshop/image/cross.png'>";  
       }
       
     }
     elseif($gettype==5)
     {
 $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$username'");   
 $checking = $vbulletin->db->fetch_array($query); 
     if($checking['userid'])
       {
           $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
           $checkinggroup = $vbulletin->db->fetch_array($query);
          $checksetting = explode(",",$checkinggroup['setting']);
                           if($checksetting[0]==0)      
                                    {
                                 $display ="<img src='./fshop/image/stop.png'>";    
                                    }else
                             {      
   
                             $display ="<img src='./fshop/image/tick.png'>"; 
                             }
       }else
       {
       $display ="<img src='./fshop/image/tick.png'>";  
       }
         
        
     }
 echo $display;
?>