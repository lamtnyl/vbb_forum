<?
#####################################
# 	vBHome Version 3.0 Extended		#
# 	  Code by chiplove.9xpro	 	#		
# 	   Y!m: chiplove.9xpro			#
#		Update 12/9/2010		 	#
#####################################


define('FORUM',				'/home/grvuekdv/domains/muabaninfo.net/public_html/'); 	// up file test.php len forum roi chay de lay duong dan
if(!is_dir(FORUM)) 			die('The path to the directory forum is not defined correctly!');

include(FORUM . '/includes/config.php');
include(FORUM . '/includes/class_core.php');
include(FORUM . '/includes/functions.php');
include('class_mysql.php');

define('TABLE_PREFIX',		$config['Database']['tableprefix']);
define('COOKIE_PREFIX',		$config['Misc']['cookieprefix']);

define('VBHOME_PREFIX', 	'1vbhome_');
define('VBHOME_VERSION', 	'vBHome 3.0 Extended'); 

define('template_main', 	'main.html');
define('template_ajaxbox', 	'ajaxbox.html');

$forum_url = 'http://muabaninfo.net/';

$db =& new Mysql;
$db->connect(
	$config['MasterServer']['servername'], 
	$config['Database']['dbname'],
	$config['MasterServer']['username'],
	$config['MasterServer']['password']
);


if(THIS_SCRIPT != 'vbhome_install'){
	$result = $db->query("
		SELECT name, value FROM " . VBHOME_PREFIX . "config 
		" . ((defined(vbhome_musiclist)) ? "WHERE name = 'music_list'" : "") . "
	");
	while($r = $db->fetch_array($result)){
		$$r['name'] = stripslashes($r['value']);
	}
	
	$description 	= $web_title . ' - ' . $keywords;
	$showthread 	= $forum_url . '/showthread.php?t=';
	$forumdisplay 	= $forum_url . '/forumdisplay.php?f=';		
	$db->free_result($result);
}


?>