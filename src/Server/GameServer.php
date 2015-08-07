<?php
namespace OctoTanks\Server;

use React\EventLoop\Factory;
use React\Socket\Server;

class GameServer {

private $handler;

public function __construct() {
	$this->handler = new Handler();

	$this->connect($this->handler);
}

private function connect($handler) {
	$loop = Factory::create();

	$socket = new Server($loop);
	$socket->on("connection", function ($conn) {
		// New connection is made.
		// Need to handshake, then store reference to connection.
		$conn->on("data", [$this->handler, "handshake"]);

		// $conn->write("Hello there!\n");
		// $conn->write("Welcome to this amazing server!\n");
		// $conn->write("Here's a tip: don't say anything.\n");

		// $conn->on('data', function ($data) use ($conn) {
		// 	$data = trim($data);
		// 	if($data === "exit") {
		// 		$conn->close();
		// 	}

		// 	echo "Incoming: $data\n";
		// 	$conn->write("You just said: $data");
		// });
	});

	$socket->listen(1337);
	$loop->run();
}

}#