<? session_start();
define('THIS_SCRIPT', 'vbhome_install');
include ('inc/config.php');
$security = '123789';
#####################################
# 	vBHome Version 3.0 Extended		#
# 	  Code by chiplove.9xpro	 	#		
# 	   Y!m: chiplove.9xpro			#
#		Update 12/9/2010		 	#
#####################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Instal / Uninstall vBHome 3.0 Extended</title>
</head>

<body>
<h3>Instal / Uninstall vBHome 3.0 Extended</h3>

<?
if($_POST['do']){
	if(trim($_POST['security']) == $security){
		$_SESSION['login'] = true;
		echo 'Login oke';
	}
	else
		echo 'Sai pass rồi';
}

if(!$_SESSION['login']){
	echo '
<p><form action="" method="post">
Security: <input name="security" type="text" size="15" /><input name="do" type="submit" value="Submit" />
</form></p>';
}
else{ 
	echo '
<p><a onclick="return confirm(\'Do you want install vBHome 3.5 Extended?\');" href="?do=install">Install</a> | 
<a onclick="return confirm(\'Do you want uninstall vBHome 3.5 Extended?\');" href="?do=uninstall">Uninstall</a></p>';


switch($_GET['do']):
	case 'install':
		/* Create table & insert data for ads*/
		$db->query("
			CREATE TABLE IF NOT EXISTS `".VBHOME_PREFIX."ads` (
			  `adid` int(11) NOT NULL auto_increment,
			  `name` varchar(100) NOT NULL,
			  `code` text NOT NULL,
			  PRIMARY KEY  (`adid`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
		");
		$db->query("
			INSERT INTO `".VBHOME_PREFIX."ads` (`adid`, `name`, `code`) VALUES
			(1, 'Nav full site', ''),
			(2, 'Main center', ''),
			(3, 'Right top', ''),
			(4, 'Right center', ''),
			(5, 'Right bottom', '');
		");
		
		/* Create table box */
		$db->query("
			CREATE TABLE IF NOT EXISTS `".VBHOME_PREFIX."box` (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(150) NOT NULL,
			  `name_tcat` varchar(50) NOT NULL,
			  `id_box` varchar(50) NOT NULL,
			  `orderid` int(11) NOT NULL,
			  `spot` tinyint(1) NOT NULL,
			  `limit_item` int(11) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
		/* Create table config */
		$db->query("
			CREATE TABLE IF NOT EXISTS `".VBHOME_PREFIX."config` (
			  `name` varchar(50) NOT NULL,
			  `value` text NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		");
		
		$db->query("
			INSERT INTO `".VBHOME_PREFIX."config` (`name`, `value`) VALUES
			('web_title', 'Web title'),
			('keywords', 'tu khoa, tu khoa'),
			('announcement', ''),
			('music_list', '[HOST]http://server-chua-nhac.com/thay-cho-localhost/[/HOST]\r\n\r\n[Track]\r\n[Title]ChipLove''s Family[/Title]\r\n[Song]Welcome to chiplove.biz [/Song]\r\n[Link]http://chiplove.biz/360Plus/not_intro.mp3[/Link]\r\n[DL]http://chiplove.biz/360Plus/not_intro.mp3[/DL]\r\n[image]nhacnen/info.jpg[/image]\r\n[/Track]\r\n\r\n[Track]\r\n[Title]ChipLove''s Family[/Title]\r\n[Song]Welcome to chiplove.biz [/Song]\r\n[Link]http://localhost/folder/tenbaihat.mp3[/Link]\r\n[DL]http://localhost/folder/tenbaihat.mp3[/DL]\r\n[image]nhacnen/info.jpg[/image]\r\n[/Track]'),
			('music_autoplay', '0'),
			('tpl_folder', 'chip_style'),
			('vbhome_mod', '119243,436,1'),
			('tagcloud', '1'),
			('poll_threadid', 0),
			('target', '_blank');
		");
		
		$db->query("
			CREATE TABLE IF NOT EXISTS `".VBHOME_PREFIX."main` (
			  `id` int(11) NOT NULL auto_increment,
			  `orderid` tinyint(4) NOT NULL,
			  `title` varchar(200) NOT NULL,
			  `intro` varchar(500) NOT NULL,
			  `link` varchar(250) NOT NULL,
			  `img` varchar(250) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
		");
		
		$db->query("
			INSERT INTO `".VBHOME_PREFIX."main` (`id`, `orderid`, `title`, `intro`, `link`, `img`) VALUES
			(1, 5, 'Title', '', '', ''),
			(2, 2, 'Title', '', '', ''),
			(3, 1, 'Title', '', '', ''),
			(4, 4, 'Title', '', '', ''),
			(5, 3, 'Title', '', '', '');
		");
		$db->query("
			CREATE TABLE IF NOT EXISTS `".VBHOME_PREFIX."rightpost` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(150) NOT NULL,
			  `link` varchar(250) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	echo 'Install Done!';
	break;
	case 'uninstall':
		$db->query("DROP TABLE IF EXISTS `".VBHOME_PREFIX."ads`");
		$db->query("DROP TABLE IF EXISTS `".VBHOME_PREFIX."box`");
		$db->query("DROP TABLE IF EXISTS `".VBHOME_PREFIX."config`");
		$db->query("DROP TABLE IF EXISTS `".VBHOME_PREFIX."main`");
		$db->query("DROP TABLE IF EXISTS` ".VBHOME_PREFIX."rightpost`");
		
		echo 'Uninstall Done!';
	break;	
endswitch;
}
?>

</body>
</html>