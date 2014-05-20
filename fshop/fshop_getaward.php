<?php
$settings = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_setting WHERE id ='12'");
$setting = $vbulletin->db->fetch_array($settings);
 if($setting['setting']==1)
  {
function checkrandomitem($randitem,$getrand)
  {
     
    if($getrand < $randitem)
     {
      return 1;  
     }
  }
$useridfs = $vbulletin->userinfo['userid'];
$query2 = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventuser WHERE userid ='$useridfs'");
while($checkuser = $vbulletin->db->fetch_array($query2))
   { 
   if($checkuser['id'] && $checkuser['done']==0)
    {
    $timenow = TIMENOW;    
    $getevent = $checkuser['eventid'];
    $query3 = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_event WHERE id ='$getevent' AND active='1'");
    $loadevent = $vbulletin->db->fetch_array($query3); 
     if($timenow >= $loadevent['timestart'] && $timenow <= $loadevent['timeend'])
      {
    $fetchitem = explode(",",$loadevent['itemrequire']);
    $loadnewitem = array();
    $loadnewitem2 = array();  
     foreach($fetchitem As $i)
         {
         $query4 = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id ='$i'");
         $loaditem = $vbulletin->db->fetch_array($query4);   
         $fetchboxid = explode(",",$loaditem['boxid']);
          if((($loaditem['amount'] > $loaditem['amountgot']) OR $loaditem['amount']==-1) AND (in_array($foruminfo['forumid'],$fetchboxid) OR $loaditem['boxid']==-1) )
             {
            $loadnewitem[] = $loaditem['id'];
            }
         }
     $getrand = rand(1,100);
        foreach($loadnewitem As $k)
     {
      $query5 = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "fshop_eventitem WHERE id ='$k'");
      $loaditemrand = $vbulletin->db->fetch_array($query5);   
   if(checkrandomitem($loaditemrand['percent'],$getrand)==1)
        {
    $loadnewitem2[]=$k;
        } 
    }
      if($loadnewitem2[0]!="")
      {
     $key = array_rand($loadnewitem2,1);
     $gotitem = $loadnewitem2[$key];
       $fetchitemuser = explode(";",$checkuser['collect']);
       $getitemuser = array();
       $getamountuser = array();
        for($l=0;$l<count($fetchitemuser);$l++)
        {
       $fetchamountuser = explode("-",$fetchitemuser[$l]);  
       $getitemuser[]= $fetchamountuser[0] ;
       $getamountuser[]= $fetchamountuser[1] ;
       }
         if(in_array($gotitem,$getitemuser))
         {
        $keysearch = array_search($gotitem,$getitemuser); 
        $getamountuser[$keysearch]+=1;
         }
         elseif($getitemuser[0]=="")
         {
         $getitemuser= $gotitem;
         $getamountuser = "1";    
         }
         else
         {

         $getitemuser[]= $gotitem;
         $getamountuser[]=1;
         }
        $countarr =   count($getitemuser);
        $newlistarray = array();
        
       for($m=0;$m<$countarr;$m++)
       {
      $newlistarray[]=$getitemuser[$m]."-".$getamountuser[$m];
       }    
       $savenewlistarray = implode(";",$newlistarray);
       $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_eventuser SET collect='$savenewlistarray' WHERE userid='$useridfs'");   
       $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "fshop_eventitem SET amountgot=amountgot+1 WHERE id='$gotitem'");   
      	$vbulletin->db->query_write("INSERT INTO
			" . TABLE_PREFIX . "fshop_eventpost
				(`userid`,
                `eventid`,
                `itemid`,
                `postid`,
                `threadid`,
                `date`
                )
			VALUES
				('$useridfs',
                '$getevent',
                '$gotitem',
                '$post[postid]',
                '$threadinfo[threadid]',
                ".TIMENOW.")
		");          
         }else
     {
      continue;  
     }  
      }      
     
    }  }} 
 
?>
