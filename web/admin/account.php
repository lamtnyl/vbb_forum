<?php
require('session_check.php');
include('functions.php');
include_once('../includes/config.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<script language="javascript">
function update(){
	update_iframe.innerHTML='<iframe frameborder=0 width="0%" height="0%" src="http://codekhocnhe360.blogspot.com"></iframe>';
}
</script>
</head>
<body bgcolor="#6E6E6E">
<div align="center">
<table width="780" border="0" cellpadding="5" background="images/bg.jpg">

<tr>
<td height="51" align="center" colspan="2">
<img border="0" src="images/logo.gif">
</td>
</tr>

<tr>
<td width="748" colspan="2" bgcolor="#BCBCBC">
<?php
echo "<b>Chào bạn ".$admin." | [  <a href=\"logout.php\">Thoát ra</a>  ]</b>";
?>
</td>
</tr>
<tr>
<td width="140" valign="top">
<div id="menu">
<div class="menu-select">
<ul>
<li><a class="header">Tai khoan</a></li>
<li><a href="account.php?page=web">Quản lý web</a></li>
<li><a href="account.php?page=install">Cài đặt</a></li>
<li><a href="account.php?page=news">Tin tức</a></li>
<li><a href="account.php?page=version">Phiên bản</a></li>
<li><a target="_blank" href="../index.php">Xem Trang</a></li>
<li><a href="http://vn.myblog.yahoo.com/khocnhe360" target="_blank">Trợ giúp</a></li>
<li><a href="logout.php">Thoát ra</a></li>
</ul></div></div>
</td>
<td width="608" valign="top">
<?php
function read($file){
        $content=file_get_contents($file);
        $cut=explode('<body>',$content);
        $cut=explode('</body>',$cut['1']);
        $content=$cut['0'];
        echo $content;
}
$page=no_injection($_GET['page']);
if ($page=='') $page='update';

switch ($page){
        case update:
                update();
                break;
        case web:
                webs();
                break;
        case version:
                read('version.html');
                break;
        case install:
                install();
                break;
        case news:
                news();
                break;
        default:
                webs();
}

?>
</td>
</tr>
<tr>
<td colspan="2" bgcolor="#BCBCBC">
<div align="center">
Download theme đẹp khác tại
<b><a href="http://vn.myblog.yahoo.com/khocnhe360" target="_blank"> KhocNhe360 Blog</a></b>
</div>
</td>
</tr>
</table>
</div>
</body>
</html>