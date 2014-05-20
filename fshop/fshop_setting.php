<?php
function setting($id)
 {
 global $vbulletin;
$settings = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id ='$id'");
$setting = $vbulletin->db->fetch_array($settings);
return $setting['setting'];
  }

function convert_date_to_timestamp($period)
{
  global $vbulletin;
	if ($period[0] == 'P')
	{
		return 0;
	}

	$p = explode('_', $period);
	$d = explode('-', date('H-i-n-j-Y'));
	$date = array(
		'h' => &$d[0],
		'm' => &$d[1],
		'M' => &$d[2],
		'D' => &$d[3],
		'Y' => &$d[4]
	);

	$date["$p[0]"] += $p[1];
	return mktime($date['h'], 0, 0, $date['M'], $date['D'], $date['Y']);
}

function convert_timestamp_to_date($timestamp)
{
 global $vbulletin;   
$date =  vbdate($vbulletin->options['dateformat'] . ', ~ ' . $vbulletin->options['timeformat'],$timestamp);
return $date;
}

function getamountitems()
 {
 global $vbulletin;
$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE active ='1'");
$amountquery = $vbulletin->db->num_rows($query);
return $amountquery;    
 }
 
function getamountitemusers($userid)
 {
 global $vbulletin;
$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");
$amountquery = $vbulletin->db->fetch_array($query);
  if($amountquery['items']!="")
  {
$getamountuseritem = count(explode(";",$amountquery['items']));
  }else
  {
 $getamountuseritem=0;   
  }
return $getamountuseritem;    
 }
 
function getamountview($userid)
 {
 global $vbulletin;
$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid'");
$getview = $vbulletin->db->num_rows($query);
 return $getview;    
 }

function getamountevent($userid)
 {
 global $vbulletin;
$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE active='1'");
$getevent = $vbulletin->db->num_rows($query);
 return $getevent;    
 }

function getamountmanagerevent()
 {
 global $vbulletin;
$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE done!=0");
$getmanagerevent = $vbulletin->db->num_rows($query);
 return $getmanagerevent;    
 }
 
function checkitemtitleon($userid)
 {
  global $vbulletin;   
  $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_timeleft");   
           while($checkitemon = $vbulletin->db->fetch_array($query))
            {
                if($checkitemon['itemtype']==1)
                 {
                   $fetchcheck = explode("||",$checkitemon['settingtype']);  
                   if($userid==$fetchcheck[1])
                    {
                    $itemon=1;   
                    break; 
                    }
                 }elseif($checkitemon['itemtype']==3)
                 {
                  
                   $fetchcheck = explode("||",$checkitemon['settingtype']);  
                   if($userid==$fetchcheck[0])
                    {
                    $itemon=3;
                    break;    
                    }  
                 }
            }      
 return $itemon;
 }

function banfshop($usernameban,$groupnoban,$reason,$itemid)
 {
  global $vbulletin,$vbphrase;   
   $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_items WHERE id='$itemid'");   
    $getinfoitem = $vbulletin->db->fetch_array($query);
  $timeban=$getinfoitem['time'];
    $fetchsetting = explode(",",$getinfoitem['setting']);
  $movetogroup = $fetchsetting['4'];
  $showusername = $fetchsetting['1'];
   $itemtype = $getinfoitem['itemtype']; 
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$usernameban'");   
                 $checking = $vbulletin->db->fetch_array($query);
                         {
                               if($checking['userid'])
                                  {
                                    $query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "userban WHERE userid='$checking[userid]'");   
                                    $checkingbanon = $vbulletin->db->fetch_array($query); 
                                     if($checkingbanon['userid'])
                                      {
                                      $requestfshop = "$vbphrase[fshop_banon]" ;     
                                      }else
                                      {
                              $fetchgroupnoban= explode(";",$groupnoban)  ;
                                if(in_array($checking['usergroupid'],$fetchgroupnoban))      
                                    {
                                  $requestfshop="$vbphrase[fshop_cantban]";      
                                    }else
                                    {
                                    $userid = $vbulletin->userinfo['userid'];
                                    $username = $vbulletin->userinfo['username'];    
                                    if($timeban==-1)
                                     {
                                      $timeban=0;  
                                     }  
                                   if($showusername==1)
                                   {
                                   $reason .="<BR>Banned By $username" ;
                                   }
                   $liftdate = convert_date_to_timestamp("D_$timeban");
   	$vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "userban
				(
                `userid`,
                `usergroupid`,
				`displaygroupid`,
                `usertitle`,
                `customtitle`,
                `adminid`,
                `bandate`,
                `liftdate`,
                `reason`)
			VALUES
				('$checking[userid]',
                '$checking[usergroupid]',
				'$checking[displaygroupid]',
                '$checking[usertitle]',
                '$checking[customtitle]',
                '$userid',
                " . TIMENOW . ",
                '$liftdate',
                '$reason')
		");          
   
                                   
   	$user = $vbulletin->db->query_first("SELECT * FROM " . TABLE_PREFIX . "user WHERE username='$usernameban'");                                                          
    $userdm =& datamanager_init('User', $vbulletin, ERRTYPE_SILENT);
	$userdm->set_existing($user);
	$userdm->set('usergroupid', $movetogroup);
	$userdm->set('displaygroupid', 0);

   	// update the user's title if they've specified a special user title for the banned group
	if ($vbulletin->usergroupcache["{$movetogroup}"]['usertitle'] != '')
	{
		$userdm->set('usertitle', $vbulletin->usergroupcache["{$movetogroup}"]['usertitle']);
		$userdm->set('customtitle', 0);
	}
 
	$userdm->save();
	unset($userdm);   
    
     	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");   
        $loaditem = $vbulletin->db->fetch_array($query);
     $loaditems = explode(";",$loaditem['items']);
    $loadamounts = explode(";",$loaditem['amountitems']);
    $keysearch = array_search($itemid,$loaditems);  
        
           $amountitemnow = $loadamounts[$keysearch];
           if($amountitemnow==1)
              {
              unset($loaditems[$keysearch]);
              unset($loadamounts[$keysearch]);
              }else
              {
                         $loadamounts[$keysearch]=$loadamounts[$keysearch]-1;
              }
        $saveitemuse = implode(";",$loaditems)   ;
        $saveamountuse = implode(";",$loadamounts)   ; 
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_user SET items='$saveitemuse',amountitems='$saveamountuse'  WHERE userid='$userid'");   
           
           if($timeban!=-1)
           {
 	$vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_timeleft
				(`itemid`,
                `userid`,
				`itemtype`,
                `timeleft`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                '$liftdate',
                ".TIMENOW.",
                '$usernameban')
		");  }else
        {
    	$query = $vbulletin->db->query_read("DELETE FROM " . TABLE_PREFIX . "fshop_timeleft WHERE userid='$userid' AND itemtype='4'");  
        }   
        	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_userlogs WHERE userid='$userid' AND itemtype='$itemtype'");   
            $checklog = $vbulletin->db->fetch_array($query);   
            if(!$checklog['userid'])
            {  
    	$vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_userlogs
				(`itemid`,
                `userid`,
				`itemtype`,
                `timeused`,
                `settingtype`)
			VALUES
				('$itemid',
                '$userid',
				'$itemtype',
                ".TIMENOW.",
                '$usernameban')
		"); }
    
    
      $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_user SET items='$saveitemuse',amountitems='$saveamountuse'  WHERE userid='$userid'");   
     $requestfshop = "$vbphrase[fshop_done]<br> <Br><img src='fshop/image/loading.gif'><meta http-equiv='refresh' content='2;url=fshop.php?do=equip'>" ;
    
      
                                    } 
                                      }
                            
                                 }else
                                 {
                                $requestfshop = "$vbphrase[fshop_notavailablemember]" ;       
                                 }
                          }   
    
 return $requestfshop ;
 }

function saveitemamount($userid,$itemid)
 {
   global $vbulletin;  
  	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_user WHERE userid='$userid'");   
    $checking = $vbulletin->db->fetch_array($query);
    $checkitem = explode(";",$checking['items']);
    $amountitem = explode(";",$checking['amountitems']);
    $keysearch = array_search($itemid,$checkitem); 
        $amountitemnow = $amountitem[$keysearch];
           if($amountitemnow==1)
              {
              unset($checkitem[$keysearch]);
              unset($amountitem[$keysearch]);
              }else
              {
                         $amountitem[$keysearch]=$amountitem[$keysearch]-1;
              }
        $saveitemuse = implode(";",$checkitem)   ;
        $saveamountuse = implode(";",$amountitem)   ;     
       
        $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_user SET items='$saveitemuse',amountitems='$saveamountuse'  WHERE userid='$userid'");   
           
   
      
 }


function html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text{$i};
        $result .= $symbol;

        switch ($symbol)
        {
            case '<':
                $is_open   = true;
                $grab_open = true;
                break;

            case '/':
                if ($is_open)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}
 
 
 
?>