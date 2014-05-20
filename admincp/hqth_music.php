<?php    
    error_reporting(E_ALL & ~E_NOTICE & ~8192);
    require_once('./global.php');
	DEFINE('_ISO','charset=UTF-8');
	if($_REQUEST['do'] == 'setting'){
 	    print_cp_header("Hoangtu_Ech's Hacks ");
        print_form_header('hqth_music','update_reg');       		
		print_table_header("[HQTH] MUSIC GIFT FOR YOU",10);		
        print_cells_row(array("Id","Poster","Reciever","Song","Link","Messages","Status","Auto Play","Date","<input type=\"checkbox\" name=\"checkall\" onclick=\"checkUncheckAll(this);\"/>"),$width = '85%',1,0,-2);
        $q1= $vbulletin->db->query_read("SELECT * FROM ". TABLE_PREFIX ."hqth_music ORDER BY dateline DESC");	   	           		
		        $page = $_GET[page]; 
				$cm_count = mysql_num_rows($q1);								
                        if (!$page) $page = 1;
				$set = $vbulletin->options['hqth_music_page'];
				$totalpage = ceil($cm_count / $set);
				for ($i = 1; $i <= $totalpage; $i++)
				{
					$pagenum = $i;
					if ($page == $pagenum) $pagenum = '[<b>'.$pagenum.'</b>]';					
					$pagenav .= '<a href="hqth_music.php?do=setting&page='.$i.'">&nbsp;'.$pagenum.'</a>';
					
				}
				$start = ($page - 1) * $set;			                
        $q1= $vbulletin->db->query_read("SELECT * FROM ". TABLE_PREFIX ."hqth_music ORDER BY dateline DESC LIMIT $start,$set");	  
        $i=1;      
        while($h = $db->fetch_array($q1)){		
		
		$h[dateline] = date('d/m/y, h:i:s',$h[dateline]);
		
		if($h[pulish] == 0) {$h[pulish] = "<input type=\"button\" name=\"offline\" value=\"Offline\"onclick=\"window.location = 'hqth_music.php?do=offline&id=$h[id]'\" />" ; } 
		else {$h[pulish] = "<input type=\"button\" name=\"Online\" value=\"Online\"onclick=\"window.location = 'hqth_music.php?do=online&id=$h[id]'\" />" ; } 
		if($h[autoplay] == 1) {$h[autoplay] = "<input type=\"button\" name=\"auto\" value=\"auto\"onclick=\"window.location = 'hqth_music.php?do=noauto&id=$h[id]'\" />" ; } 
		else {$h[autoplay] = "<input type=\"button\" name=\"Online\" value=\"noauto\"onclick=\"window.location = 'hqth_music.php?do=auto&id=$h[id]'\" />" ; } 
        if($i%2==0) $class = 'alt2'; else $class = 'alt1';		
        print_cells_row(array(                              
                              "$h[id]",
                              "$h[nguoigui]",
                              "$h[nguoinhan]",
                              "<input type=\"text\" name=\"baihat$i\" value=\"$h[baihat]\"/>",
							  "<input type=\"text\" name=\"link$i\" size=\"20\" value=\"$h[link]\"/>",
							  "<input type=\"text\" name=\"message$i\" size=\"30\" value=\"$h[message]\"/>",
							  "$h[pulish]",
							  "$h[autoplay]",
							  "$h[dateline]",
							  "<form action='hqth_music.php' method='post'><input type=\"hidden\" name=\"ii\" value=\"$i\"/><input type=\"hidden\" name=\"id$i\" value=\"$h[id]\"/><input type=\"checkbox\" name=\"check[".$h[id]."]\"/>"		
                              
        ),0,0,0); 
        $i++;
        }
		echo "  <script type=\"text/javascript\"> 
		            function checkUncheckAll(theElement) {
                        var theForm = theElement.form, z = 0;
	                    for(z=0; z<theForm.length;z++){
                            if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall'){
	                            theForm[z].checked = theElement.checked;
	                        }
                        }
                    } 
			    </script>";  
				
		print_cells_row(array('','','','','',"Pages: $pagenav",'',"<center><select name='action'>
	        <option value=\"0\">----------------------</option>	
            <option value=\"onl_all\">---- Online ----</option>
            <option value=\"off_all\">---- Offline ----</option>
            <option value=\"auto_all\">---- AutoPlay ----</option>
            <option value=\"noauto_all\">---- No AutoPlay ----</option>
            <option value=\"delete\">---- Delete ----</option>  
            </select>"," <input type=\"submit\" name=\"GO\" value=\"GO\"/></center></form>",""),0,0,0); 			
		print_submit_row($vbphrase['update'],'Reset',10);				        
		print_table_footer();	                   
		exit();
	}	
	$check = $_POST[check];	
	if($_REQUEST['do'] == 'offline'){
	    $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET pulish = 1 WHERE id = ".$_GET[id]."");
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}	
	if($_REQUEST['do'] == 'online'){
	    $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET pulish = 0 WHERE id = ".$_GET[id]."");
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}	
	if($_REQUEST['do'] == 'auto'){
	    $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET autoplay = 1 WHERE id=".$_GET[id]."");
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
	if($_REQUEST['do'] == 'noauto'){
	    $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET autoplay = 0 WHERE id=".$_GET[id]."");
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
		
	// Process with select checkbox
	
	if(empty($check) AND $_REQUEST['action'] != '0') {
	    echo '=_____________________________= match error ..... Please goback ....';
		exit();
	}	
	
	if($_REQUEST['action'] == 'off_all'){
	    
		foreach($check as $id => $v) {
	        $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET pulish = 0 WHERE id = ".$id."");
		}	
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
	if($_REQUEST['action'] == 'onl_all'){
	    
	    foreach($check as $id => $v) {
	        $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET pulish = 1 WHERE id = ".$id."");
		}	
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
	
	if($_REQUEST['action'] == 'auto_all'){
	    
		foreach($check as $id => $v) { 
	        $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET autoplay = 1 WHERE id=".$id."");
		}
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
	if($_REQUEST['action'] == 'noauto_all'){
	    
		foreach($check as $id => $v) {
	        $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET autoplay = 0 WHERE id=".$id."");
		}	
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}	    	
	
    if($_REQUEST['action'] == 'delete'){
	    
		foreach($check as $id => $v) {		
            mysql_query("DELETE FROM `hqth_music` WHERE id = ".$id."");
		}	
	    define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
    }
	if($_REQUEST['do'] == 'update_reg'){	    
		for($i = 1;$i<=$_POST[ii];$i++){
	     $vbulletin->input->clean_array_gpc('p', array(		 
		    'ii'			        => TYPE_INT,	   				
			'id'.$i			        => TYPE_INT,	   				
            'baihat'.$i			    => TYPE_STR,	   				
			'link'.$i			    => TYPE_STR,		   				
			'message'.$i			=> TYPE_STR		   				
	    ));				
        $db->query_write("UPDATE " . TABLE_PREFIX . "hqth_music SET baihat = '".$db->escape_string($_POST[baihat.$i])."', link= '".$db->escape_string($_POST[link.$i])."', message='".$db->escape_string($_POST[message.$i])."' WHERE id = ".$db->escape_string($_POST[id.$i])." LIMIT 1");					    		
		}
		define('CP_REDIRECT', 'hqth_music.php?do=setting');
	    print_stop_message('saved_settings_successfully');
	    print_cp_footer();
	    exit;
	}
	
?>		