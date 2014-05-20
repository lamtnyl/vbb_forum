<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include('includes/config.php');
include('includes/start_function.php');
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $ten_trang; ?></title>
<script language=javascript src="includes/js/checkinput.js"></script>
<script language=Javascript src="includes/js/viettyping.js"></script>
<link rel="stylesheet" href="includes/style.css" type="text/css" />
</head>

<body>
<div id="wrapper">
<div id="header">
	<img src="images/banner.jpg" border="0" />
</div>

<div id="body">
    <div id="body_left">
    	<p>
    	<a href="index.php" target="_self"><img src="images/trangchu.gif" border="0"></a>
        <a href="index.php?act=form" target="_self"><img src="images/taoweb.gif" border="0" /></a>
	    <a href="index.php?act=help" target="_self"><img src="images/huongdan.gif" border="0" /></a>
        <a href="index.php?act=list" target="_self"><img src="images/xem.gif" border="0" /></a>
    	</p>
    	<p>
	<br>
	<b>Theme mới nhất</b>
	<br>
	<?php echo $new_themes=new_theme(); ?>
	</p>
        <p>
	<br>
	<b>Thông tin</b>
	<br>
	<?php echo $info=total(); ?>
	</p>
    </div>
    <div id="body_main">
    	<p>
            <marquee>
            <strong>Chào mừng các bạn đến với trang tạo web của <?php echo $ten_trang; ?>, chúc các bạn có những giây phút vui vẻ !</strong>
            </marquee>
        </p>
        <div align="left" style="border-top: 1px dashed #E3B57A">
        <?php
		function no_injection($string)
		{
		$string = htmlspecialchars($string);
		$string = trim($string);
		$string = stripslashes($string);
		return $string;
		}
        $act=no_injection($_GET['act']);
        if ($act=='') {
        	echo $info=load_styles_file('html/main.html');
        }
        if ($act=='form') {
        	echo $info=load_styles_file('html/form.html');
        }
        if ($act=='help') {
        	echo $info=load_styles_file('html/help.html');
        }
		if ($act=='list'){
			echo $info=web_list();
		}
         ?>
		</div>
    </div>
    <div class="vide"></div>
</div>

<div id="footer">
	<p>Bản quyền thuộc về <?php echo $ten_trang; ?> - Copyright - 2012</p>
	<p>Mọi chi tiết xin liên hệ nick name: <?php echo $nick_admin; ?></p>
	<p>Trang được phát triển trên hệ thống <a target='_blank' href='http://GiapNam.Com'><b>GiapNam.Com</b></a>
</div>
</div>

</body>
</html>
