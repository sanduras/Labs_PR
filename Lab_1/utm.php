<?php
$host = gethostbyname('utm.md');
$port     = 443;
$timeout = 30;
$cert = 'e:\www\workspace\php\sockets\server.pem'; // Path to certificate
$context = stream_context_create(
    array('ssl'=>array('local_cert'=> $cert))
);
if ($socket = stream_socket_client(
    'tlsv1.2://'.$host.':'.$port,
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $context)
) {
    fwrite($socket, "\n");
    echo fread($socket,8192);
    fclose($socket);
} else {
   echo "ERROR: $errno - $errstr\n";
}
?>