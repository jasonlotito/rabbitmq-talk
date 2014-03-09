<?php
// php receive.php queue_name routing_key
require_once 'vendor/autoload.php';
$config = require('config.php');
use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
/** @var \PhpAmqpLib\Channel\AMQPChannel $queue */

$routingKey = $argv[2];
$queueName = $argv[1];

$queue = $channel->queue_declare($queueName, false, false, false, false);

$channel->queue_bind($queueName, $config['exchange'], $routingKey);

echo " [*] Waiting for $routingKey messages. To exit press CTRL+C", "\n";

$handler = function($message) use($channel){
  echo sprintf('Message: %s' . PHP_EOL, $message->body);
};

$channel->basic_consume($$queueName, $config['consumer-tag'], true, true, false, false, $handler);

while(count($channel->callbacks)){
  $channel->wait();
}
