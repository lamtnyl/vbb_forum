<?php error_reporting(0); ?>
                       <?php
SESSION_start();
$pass = 'chitam01@'; // Mat khau de them ip vao file txt
$file_listip = "themip.txt"; // file txt co nhiem vu them ip
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Kiem tra IP</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
$fopen_ip = fopen($file_listip, "r");

while ( !feof($fopen_ip) )
    {
        $read_ip = fgets($fopen_ip,50);
        $ip = explode('<nbb>', $read_ip);
        $list_ip[] = $ip[1];
    }
    fclose($fopen_ip);

if ( in_array($_SERVER['REMOTE_ADDR'], $list_ip) ){ 
        echo "<center>IP da duoc cap nhat.</center>";
    }
else {
    if ($_POST[submit]) {
        if ($_POST[code] == "$pass") $_SESSION['code'] = "$pass";
    }
    if (!$_SESSION['code'] || $_SESSION['code'] != "$pass") {
        echo "<center><form action='' method=post>
        Code: <input type=password name=code> <input type=submit name=submit value=Submit>
        </form></center>
        ";
        exit;
    }
        $new_ip = $_SERVER['REMOTE_ADDR'];
        $fp = fopen($file_listip, "a+");  
        fputs ($fp, "<nbb>$new_ip<nbb>\n");  
        fclose($fp);
        echo "<center>IP them thanh cong.</center>";
}
?>
</body>
</html>
