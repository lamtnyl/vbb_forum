<?php error_reporting(0); ?>
<?php
$list_ip = array(
          // IP b?n
      // IP Hosting
    );
$file_listip = "insertip.txt"; // Kiem tra xem trong file themip.txt co ip dang truy cap khong.
$fopen_ip = fopen($file_listip, "r");

while ( !feof($fopen_ip) )
    {
        $read_ip = fgets($fopen_ip,50);
        $ip = explode('<nbb>', $read_ip);
        $list_ip[] = $ip[1];
    }
    fclose($fopen_ip);

if ( !in_array($_SERVER['REMOTE_ADDR'], $list_ip) ){ 
        echo "<center></center>";
        exit();
    }