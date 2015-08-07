<?php
namespace OctoTanks\Server;

class Handler {

public function __construct() {}

public function handshake($data, $conn) {
	$headers = \http_parse_headers($data);
	$uuid = $headers["Sec-WebSocket-Key"];
	$conn->write("HTTP/1.1 101 Switching Protocols\r\n"
		. "Upgrade: websocket\r\n"
		. "Connection: Upgrade\r\n"
		. "Sec-WebSocket-Accept: $uuid"
	);

	$conn->removeListener("data", [$this, "handshake"]);
	$conn->on("data", [$this, "receive"]);
}

public function receive($data) {
	die("Everything is ok!!");
}

}#