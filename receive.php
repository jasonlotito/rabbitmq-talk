<?php

require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, true);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$handler = function($message) use($channel){
  echo sprintf('Message: %s' . PHP_EOL, $message->body);
};

$channel->basic_consume('hello', false, true, true, false, false, $handler);
$channel->wait();
