
<?php
error_reporting(E_ALL);


/* Get the port for the WWW service. */
$service_port = 80;

/* Get the IP address for the target host. */
$address = gethostbyname('me.utm.md');

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";
$result = socket_connect($socket, $address, $service_port) or  die("Could not connect to server\n");
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

$in = "GET / HTTP/1.1\r\n";
$in .= "Host: me.utm.md:80\r\n";
$in .= "Connection: Close \r\n\r\n";
$in .= "Accept-Language: ro\r\n\r\n";
$in .= "Content-Language: en, ru\r\n\r\n";
$in .= "Save-Data: <sd-token>\r\n\r\n";

$out = '';
echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
echo "OK.\n";
$str = "";
echo "Reading response:\n\n";
while ($out = socket_read($socket, 2048)) {

    $str.=$out;
}
socket_close($socket);
preg_match_all('/[^\"\']*\.(?:png|jpg|gif)/m',  $str, $matches);
$http = 'http://';
foreach ($matches as $arr) {
    foreach ($arr as $index=>$value) {
        // echo $value.'<br>';
        // echo gettype($value);
        if (strpos($value, $http) !== false) { 
                $value =$value;
        }
        else {
            $value = substr_replace($value, 'http://me.utm.md/', 0, 0);
        }
        
        // echo $value.'<br>';

        $url_to_image = $value;
        $my_save_dir = 'images/';
        $filename = basename($url_to_image);
        $complete_save_loc = $my_save_dir . $filename;
        file_put_contents($complete_save_loc, file_get_contents($url_to_image));
        
    }
}




?>