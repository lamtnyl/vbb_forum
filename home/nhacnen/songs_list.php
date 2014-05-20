<? 
define('THIS_SCRIPT', 'vbhome_musiclist');
include("../inc/config.php");

/* [Track]
[Title] Ca sĩ [/Title]
[Song] Bài hát [/Song]
[Link] Link [/Link]
[DL] Linkdownload [/DL]
[/Track]
*/	

$xml = str_replace('[Track]','<track>',$music_list);
$xml = str_replace('[/Track]','</track>',$xml);
$xml = str_replace('[Title]','<title>',$xml);
$xml = str_replace('[/Title]','</title>',$xml);
$xml = str_replace('[Song]','<creator>',$xml);
$xml = str_replace('[/Song]','</creator>',$xml);
$xml = str_replace('[Link]','<location>',$xml);
$xml = str_replace('[/Link]','</location>',$xml);
$xml = str_replace('[DL]','<info>',$xml);
$xml = str_replace('[/DL]','</info>',$xml);
$xml = str_replace('[image]','<image>',$xml);
$xml = str_replace('[/image]','</image>',$xml);

$xml = preg_replace('#<info>(.*)</info>#i', '', $xml);

$x = explode('[HOST]', $xml);
$x = explode('[/HOST]', $x[1]);
$link_host = $x[0];

$xml = str_replace('http://localhost/', $link_host.'?/'.$hash.'/', $xml);
$xml = str_replace('[HOST]'.$link_host.'[/HOST]','',$xml);
$xml = str_replace('&','&amp;',$xml);
//	$xml = str_replace('<creator>','<creator>[chiplove.biz] - ',$xml);
header("Content-Type: application/xml; charset = utf-8");
echo '<?xml version = "1.0" encoding = "utf-8"?>
<playlist version = "1" xmlns = "http://xspf.org/ns/0/">
<trackList>
'.$xml.'
</trackList>
</playlist>';

?>










