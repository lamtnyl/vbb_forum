<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Chon Mat Cuoi</title>
<script language=javascript>
function get_icon(icon){
alert('Đã thêm hình này vào bài viết');
window.opener.document.frmInput.content.value+=icon;
}
</script>
<script language="JavaScript1.2">
<!--
top.window.moveTo(100,100);
if (document.all) {
top.window.resizeTo(550,510);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = 550;
top.window.outerWidth = 510;
}
}
//-->
</script>
</head>
<body>
<b>Chọn biểu tượng cảm xúc</b>
<br>
<?php
$icon_arr=scandir("icons");
$number_of_icon=count($icon_arr);
for($i=2;$i<$number_of_icon;$i++)
{
	if($icon_arr[$i]<>"Thumbs.db" && $icon_arr[$i]<>"index.html")
	echo "<a href=\"#\"><img src=\"icons/".$icon_arr[$i]."\" onclick='get_icon(\"((".$icon_arr[$i]."))\");'></a>";
}
?>
</body>
</html>