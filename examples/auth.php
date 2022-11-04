<?php

require_once implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);

use Kubinyete\Fraugster\Core\Environment;
use Kubinyete\Fraugster\Core\FraugsterClient;

$username   = getenv('FRAUGSTER_USER') ?? '';
$secret     = getenv('FRAUGSTER_SECRET') ?? '';

$client = new FraugsterClient(Environment::staging());
$token  = $client->getSessionToken($username, $secret);

if (!$token) {
    throw new Exception("Could not receive an session token");
} else {
    echo "Session token received!" . PHP_EOL;
}
