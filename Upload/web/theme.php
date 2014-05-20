<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Chon Theme</title>
<script language=javascript>
function gettheme(theme){
window.opener.document.frmInput.theme.value=theme;
self.close();
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
<b>Vui Lòng Chọn Mẫu Bạn Thích</b>
<br>
<?php
$theme_arr=scandir("web_themes");
$number_of_theme=count($theme_arr);
for($i=2;$i<$number_of_theme;$i++)
{
	if($theme_arr[$i]<>"thumbs.db" && $theme_arr[$i]<>"index.html")
    echo "<a href=\"#\"><img src=\"web_themes/".$theme_arr[$i]."/theme.gif\" onclick='gettheme(\"".$theme_arr[$i]."\");'></a>\n";
}
?>
</body>
</html>