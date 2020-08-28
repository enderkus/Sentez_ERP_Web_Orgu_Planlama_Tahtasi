<?php
$fp = stream_socket_client("udp://192.168.100.99", $errno, $errstr);
if (!$fp) {
    echo "HATA: $errno - $errstr<br />\n";
} else {
    fwrite($fp, "\n");
    echo fread($fp, 26);
    fclose($fp);
}
?>
