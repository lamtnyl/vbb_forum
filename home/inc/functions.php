<?
if(!function_exists('fetch_trimmed_title')){
	function fetch_trimmed_title($str, $len, $more = false){
		if (!$str || is_array($str)) return $str;
		$str = trim($str);
		if (strlen($str) <= $len) return $str;
		$str = substr($str,0,$len);
		if ($str != '') {
			if (!substr_count($str, " ") && $more) {
				if (strlen($str)>$len) $str .= " ...";
				return $str;
			}
			while($str[strlen($str)-1] != " "){
				$str = substr($str, 0, -1);
			}
			if ($more) $str .= " ...";
		}
		return $str;		
	}
}

function check_img($img){
	if(!trim($img))
		$img = 'img/no_img.gif';
	elseif(!preg_match('#http://#',$img))
		$img = 'http://i4.ytimg.com/vi/'.$img.'/default.jpg';
	return $img;	
}
function pre($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
function removebbcode($code){
	$code = preg_replace("/(\[)(.*?)(\])/i", '', $code);
	$code = preg_replace("/(\[\/)(.*?)(\])/i", '', $code);
	$code = preg_replace("/http(.*?).(.*)/i", '', $code);
	$code = preg_replace("/\<a href(.*?)\>/", '', $code);
	$code = preg_replace("/:(.*?):/", '', $code);
	$code = str_replace("<", '', $code);
	$code = str_replace("div", '', $code);
	$code = str_replace("\n", '', $code);
	return $code;
}

function intro_top_box($code){
	$code = removebbcode($code);
	if(!trim($code))
		return 'Chua có trích dẫn';
	else
		return fetch_trimmed_title($code,150,true);
}

function img_top_box($code){
	$remove_arr = array(
		'http://kenh14.vn/Images/EmoticonOng/.*',
		'http://.*/spacer.gif',
		'http://.*/blank.gif',
		'http://.*images/smilies/.*'
	);
	foreach($remove_arr as $value)
		$code = preg_replace('#\[IMG\]'.$value.'\[/IMG\]#i','',$code);		
				
	if(preg_match('/\[IMG\](.*?)\[\/IMG\]/i', $code, $m))
		return $m[1];
	elseif(preg_match('#\[YOUTUBE\]([\w-_]{1,})(&)?(.*)?\[/YOUTUBE\]#i', $code, $m))
		return 'http://i1.ytimg.com/vi/'.$m[1].'/default.jpg';
	else
		return 'img/no_img.gif';
} 


function emo_array(){
	return array(
			':)' => 1,':(' => 2,';)' => 3,':D' => 4,';;)' => 5,'>:D<' => 6,':-/' => 7,':x' => 8,':">' => 9,':P' => 10,':-*' => 11,'=((' => 12,':-O' => 13,'X(' => 14,':>' => 15,':->' => 15,'B-)' => 16,':-S' => 17,'#:-S' => 18,'>:)' => 19,':((' => 20,':))' => 21,':|' => 22,'/:)' => 23,'=))' => 24,'O:-)' => 25,':-B' => 26,'=;' => 27,':-c' => 101,':)]' => 100,'~X(' => 102,':-h' => 103,':-t' => 104,'8->' => 105,'I-)' => 28,'8-|' => 29,'L-)' => 30,':-&' => 31,':-$' => 32,'[-(' => 33,':O)' => 34,'8-}' => 35,'<:-P' => 36,'(:|' => 37,'=P~' => 38,':-?' => 39,'#-o' => 40,'=D>' => 41,':-SS' => 42,'@-)' => 43,':^o' => 44,':-w' => 45,':-<' => 46,'>:P' => 47,'>):)' => 48,'X_X' => 109,':!!' => 110,'\m/' => 111,':-q' => 112,':-bd' => 113,'^#(^' => 114,':bz' => 115,':o3' => 108,':-??' => 106,'%-(' => 107,':@)' => 49,':(|)' => 51,'~:>' => 52,'@};-' => 53,'8-X' => 59,':-L' => 62,'[-O<' => 63,'$-)' => 64,':-"' => 65,'b-(' => 66,':)>-' => 67,'[-X' => 68,'\:D/' => 69,'>:/' => 70,';))' => 71,':-@' => 76,'^:)^' => 77,':-j' => 78,'(*)' => 79
			 );
}
function alter_smiley(&$item1) {
		$item1 = "<img src='img/emoticons/$item1.gif' border='0'>";
}
function m_emotions_replace($str){
	foreach(emo_array() as $key => $value)
		$smileys[htmlspecialchars($key)] = $value;
	array_walk ($smileys, 'alter_smiley');		
	$str =  strtr($str, $smileys);
	return htmlspecialchars_decode($str);
}

?>
