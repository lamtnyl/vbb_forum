<?php
error_reporting(E_ALL & ~E_NOTICE & ~8192);
require_once('config.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<head>
<title>chatbox</title>
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="-1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<link rel="stylesheet" type="text/css" href="images/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="js/script.js"></script>
<!-- Lazy load image -->
	<script src='js/jquery.min.js' type='text/javascript'></script>
	<script src='js/jquery.lazyload.js' type='text/javascript'></script>
	<script charset='utf-8' type='text/javascript'>
		jQuery.noConflict();
		jQuery(function() {          
			jQuery("img").lazyload({
			placeholder : "images/lazypreload.gif",       
			effect      : "fadeIn"
			});
		});
	</script>
	<!-- Lazy load image -->
	<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
	<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
	<script type="text/javascript">
		hs.graphicsDir = 'highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		hs.numberPosition = 'caption';
		hs.captionEval = 'this.thumb.alt';
		hs.dimmingOpacity = 0.75;

		// Add the controlbar
		if (hs.addSlideshow) hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 5000,
			repeat: false,
			useControls: true,
			fixedControls: 'fit',
			overlayOptions: {
				opacity: .75,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
	</script>
	<script language="Javascript">
		var ajax = new sack();

		function whenLoading(){
			document.getElementById('progress').style.display="inline";
		}


		function whenCompleted(){
			document.getElementById('messresult').innerHTML = ajax.response;
			document.getElementById('progress').style.display="none";
			<?php
			if ($config['new_at_bottom']) echo "window.scrollTo(0,99999999999);";
			?>
		}

		function message_refresh(){
			ajax.requestFile = 'message.php';
			ajax.onLoading = whenLoading;
			ajax.onCompletion = whenCompleted;
			ajax.runAJAX();
		}
		autor = setInterval("message_refresh()", 1000*<?php echo $config['autorefresh']; ?>);
		<?php
			if ($config['new_at_bottom']) echo "window.scrollTo(0,99999999999);";
		?>

		function click_chat(username)
		{
			parent.document.fcb_form.hmess.value = '@'+username+': ' + parent.document.fcb_form.hmess.value;
		}
	</script>
</head>

<body style='background:url() bottom right no-repeat fixed;'>
<?php
echo '<div id="progress" style="position: fixed; right: 0px; top: 0px; display: none;">',$phrase['load'],'</div>';
echo '<div id="messresult">';
require_once('message.php');
echo '</div>';
?>
</body>
</html>