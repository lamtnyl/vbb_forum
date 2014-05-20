<?php
 $action= $_GET['doit'];
   if($action=="buy")
   {
    $iditem = $_POST['idfshop'];
    $amountitem = $_POST['amountitem'];
     if(!is_numeric($amountitem) || $amountitem=="" || $amountitem <= 0)
        {
       	eval('standard_error(Error);');      
        }
    	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$iditem'");   
        $infoitem = $vbulletin->db->fetch_array($query);
        $totalgold = $amountitem*$infoitem['gold'];
      if($infoitem['active']==0)
       {
      $requestfshop = "$vbphrase[fshop_notavailable]" ;  
       }
      elseif($infoitem['amount']==0)
      {
      $requestfshop = "$vbphrase[fshop_amountout]" ;
      }
      elseif($amountitem > $infoitem['amount'] && $infoitem['amount']!=-1)
      {
      $requestfshop = "$vbphrase[fshop_inputagain]" ;
      }
     elseif($usermoney < $totalgold)
      {
      $requestfshop = "$vbphrase[fshop_notenough] $setting4" ;
      } else
      {
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");   
    $checking = $vbulletin->db->fetch_array($query);
        if(!$checking['userid'])
         {
         	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_user
				(`userid`,
				`items`,
                `amountitems`)
			VALUES
				('" . addslashes($vbulletin->userinfo[userid]) . "',
				'$iditem',
                '$amountitem')
		");   
         }else
         {
            if($checking['items']!="")
            {
          $listitems = explode(";",$checking['items']);
          $listitemamounts = explode(";",$checking['amountitems']);
          $keyfshop = array_search($iditem,$listitems);  
          
            if(is_numeric($keyfshop))
            {
             $listitemamounts[$keyfshop] += $amountitem;  
            }else
            {
             $listitems[]=$iditem;     
             $listitemamounts[]=$amountitem;
            }
         $saveitems= implode(";",$listitems) ;
         $saveamountitems = implode(";",$listitemamounts);
           }else
           {
          $saveitems  = $iditem;
          $saveamountitems =$amountitem;
           }
   $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_user SET items='$saveitems',amountitems='$saveamountitems' WHERE userid='$userid'");    
          }     
    if($infoitem['amount']!=-1)
    {
 $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_items SET amount=amount-$amountitem WHERE id='$iditem'"); 
   }
 $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET $setting3=$setting3-$totalgold WHERE userid='$userid'");        
      
    $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php'>" ;
      }
 
  
   }elseif($action=="useitem")
     {
   $itemid = $_POST['iditem'];
   $itemtype = $_POST['itemtype'];
  
   
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");   
    $checking = $vbulletin->db->fetch_array($query);
    $checkitem = explode(";",$checking['items']);
    $amountitem = explode(";",$checking['amountitems']);
    $keysearch = array_search($itemid,$checkitem);
    
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
    $checkactive = $vbulletin->db->fetch_array($query);
    $gettime = $checkactive['time'];
       if(!in_array($itemid,$checkitem) || $checkactive['active']==0)
         {
         	eval('standard_error(Error);');        
         }
    
    if($itemtype==1)
          {
           $checkid1 = $_POST['hiditem1'];
          $checkid11 = $_POST['hiditem11'];
            $itemon = checkitemtitleon($userid);
             if($itemon==3)
               {
             $requestfshop = "$vbphrase[fshop_notimeleft]" ;
   
               }else
               {
             $oldusertitle = $vbulletin->userinfo['usertitle'];
             $oldtitlecustom = $vbulletin->userinfo['customtitle'];
             if($checkid1==1)
              {
             $vbulletin->input->clean_array_gpc('p', array(
             'changeboxfshop'    => TYPE_STR 
              ));   
              $maincontent = $_POST['changeboxfshop'];  
            }else
             {
              $maincontent = strip_tags($_POST['changeboxfshop']);  
            }
            $maincontent = $db->escape_string(substr($maincontent,0,$checkid11));  
             $maincontent = str_replace("<br","",$maincontent);  

                      
         	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
            $getinfo = $vbulletin->db->fetch_array($query);
            $timeitem = $getinfo['time'];
           $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle=\"$maincontent\",customtitle=1  WHERE userid='$userid'");
           
         
        saveitemamount($userid,$itemid);  
         
            if($gettime!=-1)
           {
        $timeleft = convert_date_to_timestamp("D_$gettime");
          
       	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='1'");   
        $checkused = $vbulletin->db->fetch_array($query);
           if($checkused['id'])
           {
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_timeleft SET timeleft='$timeleft',timeused=".TIMENOW."  WHERE id='$checkused[id]'");   
           }else
           {
       	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$timeleft',
                ".TIMENOW.",
                '$oldusertitle||$oldtitlecustom')
		");    
           }
                  }else
           {
       	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='1'");        
            }
         	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {
     	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$oldusertitle||$oldtitlecustom')
		");   } 
     $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
            }
            
          }
    elseif($itemtype==2)
       {
         $vbulletin->input->clean_array_gpc('p', array(
         'usernameban'    => TYPE_STR,
         'messagefshop' => TYPE_NOHTML,
        ));  
        
           $usernameban = $db->escape_string($_POST['usernameban']);
           $messagefshop = $db->escape_string($_POST['messagefshop']);
         
           
           	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
            $getinfo = $vbulletin->db->fetch_array($query);  
            $fetchsetting = explode(",",$getinfo['setting']);
            $groupnoban = $fetchsetting[0];
            if($fetchsetting[2]==1 && $messagefshop=="")
             {
              $requestfshop = "$vbphrase[fshop_leavemessage]" ;
              }else
              {
             $requestfshop = banfshop($usernameban,$groupnoban,$messagefshop,$itemid);   
         
              }
       }
       
    if($itemtype==3)
          {
             $vbulletin->input->clean_array_gpc('p', array(
             'getusername'    => TYPE_STR 
              ));   
             $getusername = $_POST['getusername'];
            $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$getusername'");   
            $getinfo = $vbulletin->db->fetch_array($query);  
             $useridban = $getinfo['userid'];
             $oldusertitle =$getinfo['usertitle'];
             $oldtitlecustom = $getinfo['customtitle'];
             
           $itemon = checkitemtitleon($useridban);
             $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
            $getsetting = $vbulletin->db->fetch_array($query);  
             $fetchsetting = explode(",",$getsetting['setting']);
            $checkid1 =$fetchsetting[0];
            $checkid2 = $fetchsetting[12];
            $checkid3 = $fetchsetting[11];
            $fetchgroupnotitle= explode(";",$fetchsetting[14])  ;
             
              if(!$getinfo['userid'])
                   {
                 $requestfshop = "$vbphrase[fshop_notavailablemember]" ;     
                   }
              elseif($itemon)
               {
               $requestfshop = "$vbphrase[fshop_notimelefttitle]" ;  
               }     
             elseif(in_array($getinfo['usergroupid'],$fetchgroupnotitle))      
                 {
              $requestfshop = "$vbphrase[fshop_cantchangetitle]" ;
                 }
                else
                     {                   
             if($checkid1==1)
              {
             $vbulletin->input->clean_array_gpc('p', array(
             'changeboxfshop'    => TYPE_STR 
              ));   
             $maincontent = $_POST['changeboxfshop'];  
            }else
             {
              $maincontent = strip_tags($_POST['changeboxfshop']);  
            }
          
            $maincontent = $db->escape_string(substr($maincontent,0,$checkid3));  
             $maincontent = str_replace("<br","",$maincontent);  
                if($checkid2==1)
                {
             $maincontent = str_replace("</p>"," <i>($username)</i></p>",$maincontent);  
          
                }
                                    
           $timeitem = $getsetting['time'];
           $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle=\"$maincontent\",customtitle=1  WHERE username='$getusername'");
           
         saveitemamount($userid,$itemid);
           
        if($gettime!=-1)
           {
        $timeleft = convert_date_to_timestamp("D_$gettime");
               	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$timeleft',
                ".TIMENOW.",
                '$useridban||$oldusertitle||$oldtitlecustom')
		");    
           }else
           {
            	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='3'");     
            
           }
      	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {
               	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$useridban||$oldusertitle||$oldtitlecustom')
		");    }
     $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
            
             }
          }   
       elseif($itemtype==4)
     {
      $idgroupcolor = $_POST['groupcolor'];
         if(!$idgroupcolor)
         {
         $requestfshop = "$vbphrase[fshop_chooseagroup]" ;
         }
         else
         {
      
        $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET displaygroupid='$idgroupcolor' WHERE userid='$userid'");   
       
   saveitemamount($userid,$itemid);
           $olddisplaygroupid  = $vbulletin->userinfo['displaygroupid'];      
           if($gettime!=-1)
           {
             $timeleft = convert_date_to_timestamp("D_$gettime"); 
             	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='$itemtype'");   
        $checking = $vbulletin->db->fetch_array($query);
          if($checking['id'])
           {
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_timeleft SET timeleft='$timeleft',timeused=".TIMENOW." WHERE id='$checking[id]'");   
          
           }else
           {
      
      
               	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$timeleft',
                ".TIMENOW.",
                '$olddisplaygroupid')
		");    
           } }else
           {
             	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='4'");    
            
           }
           	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {
      	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$olddisplaygroupid')
		");     }
      $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
             
         }    
        
     }
       elseif($itemtype==5)
     {
           $vbulletin->input->clean_array_gpc('p', array(
           'fakenick' => TYPE_NOHTML
        ));  
      $fakenick = $db->escape_string($_POST['fakenick']);
         if(!$fakenick)
         {
         $requestfshop = "$vbphrase[fshop_chooseanick]" ;
         }
         else
         {
        	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
            $getinfo = $vbulletin->db->fetch_array($query);  
            $fetchsetting = explode(",",$getinfo['setting']);
          
            if($fetchsetting[0]==0)
            {
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$fakenick'");   
     $checking = $vbulletin->db->fetch_array($query); 
                 if($checking['userid'])
                           {
                           $requestfshop = "$vbphrase[fshop_nickon]" ;     
                           }else
                           {
                           $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET username='$fakenick' WHERE userid='$userid'");
                           $next=1;   
                           }
       
           }else
           {
           $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET username='$fakenick' WHERE userid='$userid'");   
           $next=1;
           }
   
        if($next==1)
        {
   saveitemamount($userid,$itemid);
          
           if($gettime!=-1)
           {
             $timeleft = convert_date_to_timestamp("D_$gettime"); 
             	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='$itemtype'");   
        $checking = $vbulletin->db->fetch_array($query);
          if($checking['id'])
           {
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_timeleft SET timeleft='$timeleft',timeused=".TIMENOW." WHERE id='$checking[id]'");   
              
            
           }else
           {
      
      
               	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$timeleft',
                ".TIMENOW.",
                '$username')
		");    
           } }
           else
           {
            	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='5'");     
           }
           	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {
      	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$username')
		");      }
      $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
             
         }    
        
     }   
       }
    elseif($itemtype==6)
     {
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='6'");   
    $checkuser = $vbulletin->db->fetch_array($query);
      if($checkuser['id'])
      {
 	eval('standard_error(Error);');  
      }
      
      $effect = $_POST['effect'];
         if(!$effect)
         {
         $requestfshop = "$vbphrase[fshop_chooseagroup]" ;
         }else
         {
           $arrayk = array(1,2,3,4);
  if(in_array($effect,$arrayk))
    {
    $triptitle = strip_tags($usertitle);    
    $newtitle = "<div id='fs_rb$effect-$userid'>$triptitle</div>";
    }else
    {
     $newtitle = "<div id='fs_rb$effect-$userid'>$usertitle</div>";  
    }
    $newtitle = $db->escape_string($newtitle);
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle=\"$newtitle\" WHERE userid='$userid'"); 
    saveitemamount($userid,$itemid);
          
           if($gettime!=-1)
           {
             $timeleft = convert_date_to_timestamp("D_$gettime"); 
             	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='$itemtype'");   
        $checking = $vbulletin->db->fetch_array($query);
          if($checking['id'])
           {
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_timeleft SET timeleft='$timeleft',timeused=".TIMENOW." WHERE id='$checking[id]'");   
              
            
           }else
           {
      
      
               	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$timeleft',
                ".TIMENOW.",
                '$effect')
		");    
           } }
           else
           {
            	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='6'");     
           }
           	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {
      	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(
                `itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$effect')
		");      }
      $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
      
         }
       
     } 
   
     } elseif($action=="resetitem")
   {
    
    $itemid = $_GET['id'];

  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE itemid='$itemid' AND userid='$userid'");   
    $getreset = $vbulletin->db->fetch_array($query);   
    if(!$getreset['id'])
      {
        eval('standard_error(Error);');  
      }
      $itemtype= $getreset['itemtype'];
      $settingtype = explode("||",$getreset['settingtype']);
         switch ($itemtype) {
    case 1:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$settingtype[0]',customtitle='$settingtype[1]' WHERE userid='$userid'");   
      break;
    case 2:
     $username = $settingtype[0];
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user As user LEFT JOIN userban As userban ON(user.userid = userban.userid) WHERE user.username='$username'");   
    $getinfo = $vbulletin->db->fetch_array($query);
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usergroupid='$getinfo[usergroupid]',displaygroupid='$getinfo[displaygroupid]',usertitle='$getinfo[usertitle]',customtitle='$getinfo[customtitle]' WHERE userid='$getinfo[userid]'");   
   	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "userban WHERE userid='$getinfo[userid]'"); 
      break; 
    case 3:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$settingtype[1]',customtitle='$settingtype[2]' WHERE userid='$settingtype[0]'");   
      break;   
    case 4:
     $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET displaygroupid='$settingtype[0]' WHERE userid='$userid'");   
      break;  
    case 5:
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET username='$settingtype[0]' WHERE userid='$userid'");   
      break;  
     case 6:
   	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid='$userid'");   
    $gettitleuser = $vbulletin->db->fetch_array($query);  
    $resettitle = preg_replace("/<div[^>]+\>/i", "",$gettitleuser['usertitle']);
    $resettitle = str_replace("</div>","",$resettitle);
          $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET usertitle='$resettitle' WHERE userid='$userid'");   
      break;    
      
                 }
  $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE id='$getreset[id]'");     
  $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php'>" ;
        
    
    }
   elseif($action=="joinevent")
   {
  $idevent = $_POST['eventid'];
  
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$idevent'");   
    $getinfoevent = $vbulletin->db->fetch_array($query);   
    $goldevent = $getinfoevent['gold'];
    $listuserjoin = explode(",",$getinfoevent['playerjoin']);
       
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE userid='$userid'");   
    $checking = $vbulletin->db->fetch_array($query);   
  
    if($listuserjoin[0]=="")
     {
      $countplayerjoin=0;  
     }
     else
     {
       $countplayerjoin=count($listuserjoin) ;
     }
    if($countplayerjoin >= $getinfoevent['players'] && $getinfoevent['players']!=-1)
    {
     $requestfshop ="$vbphrase[fshop_somanyplayers]";        
    } 
    elseif($checking[$setting3] < $goldevent)
    {
   $requestfshop ="$vbphrase[fshop_notenough] $setting4";     
    }elseif(in_array($userid,$listuserjoin))
    {
    eval('standard_error(Error);');       
    }else
    {
     if($listuserjoin[0]=="")
     {
     $newlistjoin=$userid;   
     }else
     {
    $listuserjoin[]=$userid;
    $newlistjoin = implode(",",$listuserjoin) ;  
    }
  
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET $setting3=$setting3-$goldevent WHERE userid='$userid'");       
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_event SET playerjoin='$newlistjoin' WHERE id='$idevent'");  
    	$db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_eventuser
				(`userid`,
				`eventid`)
			VALUES
				('$userid',
				'$idevent')
		");        
    $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=eventid&id=$idevent'>" ;
          
    }
   }
    elseif($action=="leaveevent")
   {
    $idevent = $_POST['eventid'];
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$idevent'");   
    $getinfoevent = $vbulletin->db->fetch_array($query);   
    $listuserjoin = explode(",",$getinfoevent['playerjoin']);
    if(!in_array($userid,$listuserjoin) || $getinfoevent['done']!=0)
     {
       eval('standard_error(Error);');      
     }
    $keysearch = array_search($userid,$listuserjoin);
    unset($listuserjoin[$keysearch]);
    $savelistplayerjoin = implode(",",$listuserjoin);
    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_event SET playerjoin='$savelistplayerjoin' WHERE id='$idevent'");  
    $query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$userid' AND eventid='$idevent'");       
    $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=eventid&id=$idevent'>" ;
     }
      elseif($action=="combineitem")
   {
    $idevent = $_GET['id'];
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$userid' AND eventid='$idevent'");   
    $checkamount  = $vbulletin->db->fetch_array($query);   
     if($checkamount['done']!=0)
      {
      eval('standard_error(Error);');     
      }
    $fetchitem = explode(";",$checkamount['collect']);
       $getitem = array();
      $getamount = array();
      for($i=0;$i<count($fetchitem);$i++)
        {
       $fetchamount = explode("-",$fetchitem[$i]);  
       $getitem[]= $fetchamount[0] ;
       $getamount[]= $fetchamount[1] ;
       }
       
     $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id='$idevent'");   
     $getitems  = $vbulletin->db->fetch_array($query);     
     $itemlist = explode(",",$getitems['itemrequire']);
     if($itemlist[0]!==0)
 {
  foreach($itemlist As $k)  
    {
         $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id='$k'");   
         $infoitem = $vbulletin->db->fetch_array($query);
          $key_search = array_search($k,$getitem);
           if(in_array($k,$getitem))
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
       $l=1; 
      }else
      {
       $l=0; 
       break;
      }
       
    }
   if($l==1)
      {
        if($getitems['amountaw'] <= $getitems['amountcombined'] && $getitems['amountaw']!=-1)
        {
          $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_eventuser SET done=2,date=".TIMENOW." WHERE userid='$userid' AND eventid='$idevent'");        
        }else
        {
          $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_event SET amountcombined=amountcombined+1 WHERE id='$idevent'");         
          $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_eventuser SET done=1,date=".TIMENOW." WHERE userid='$userid' AND eventid='$idevent'");        
        }
  
 $requestfshop = "$vbphrase[fshop_eventdone]<br><br>
 <font color='red'>$getitems[name]</font> <br><img class='sgicon' src='$getitems[image]'>
  <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='5;url=fshop.php?do=eventid&id=$idevent'>" ;
       
      }else
      {
   $requestfshop = "$vbphrase[fshop_notenoughitem]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='5;url=fshop.php?do=eventid&id=$idevent'>" ;
          
      } 
    
    
    
 }    }
 
    elseif($action=="accept")
    {
 $checkusermanager = explode(",",$setting11);
 if(!in_array($userid,$checkusermanager))
   {
    eval('standard_error(Error);');   
   }
    $useridcheck=$_GET['userid'];
    $idevent = $_GET['eventid'];
    $typedone = $_GET['done'];
    
    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid='$useridcheck' AND done=1 || done=2");   
    $checkuser = $vbulletin->db->fetch_array($query); 
      if(!$checkuser['id'] || $checkuser['eventid']!=$idevent)
        {
         eval('standard_error(Error);');       
        }
      $usermanager = "$username;".TIMENOW;  
  $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_eventuser SET done='$typedone',usermanager='$usermanager' WHERE userid='$useridcheck' AND eventid='$idevent'");        
   $requestfshop = "$vbphrase[fshop_done]<br><br> <img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=managerevent'>" ;
        
    }
    
     
	$templater = vB_Template::create('fshop_request');
    $templater->register('requestfshop', $requestfshop);
	$fshop_buy = $templater->render(); 
$titlestart = "REQUEST";  


?>