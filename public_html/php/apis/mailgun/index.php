<?php

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$config = readConfig("/etc/apache2/capstone-mysql/cartridge.ini");
$mailgunKeys = json_decode($config["privkeys"])->mailgun;

$mailgunOptions = [
	"http" => [
		"method" => "POST",
		"header" => [
			"Authorization: Basic " . base64_encode("api:" . $mailgunKeys->key),
			"Content-type: application/x-www-form-urlencoded"
		],
		"content" => http_build_query([
			"from" => "Senator Arlo <cartridgecoders@gmail.com>",
			"to" => "SEGA Support <cartridgecoders@gmail.com>",
			"subject" => "Am I Still On The Team?",
			"text" => "Meow,\n\nMeow still wants to be on meow team. *purrr*\n\nSenator Arlo"
		])
	]
];
$mailgunContext = stream_context_create($mailgunOptions);
$status = file_get_contents($mailgunKeys->url, false, $mailgunContext);
var_dump($status);

?>
