<?php

require_once 'vendor/autoload.php';
$config = require('config.php');
use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
/** @var \PhpAmqpLib\Channel\AMQPChannel $queue */
$queue = $channel->queue_declare($config['queue'], false, false, false, true);
$channel->queue_bind($config['queue'], $config['exchange']);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$handler = function($message) use($channel){
  echo sprintf('Message: %s' . PHP_EOL, $message->body);
};

$channel->basic_consume($config['queue'], $config['consumer-tag'], true, true, false, false, $handler);

while(count($channel->callbacks)){
  $channel->wait();
}
