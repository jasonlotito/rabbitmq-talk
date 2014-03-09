<?php
// Setup, $ php send.php routing.key whatever you want to send
require_once 'vendor/autoload.php';
$config = require('config.php');
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Message Prep
$connection = new AMQPConnection($config['mq']['host'], $config['mq']['port'], $config['mq']['user'], $config['mq']['pass']);
$channel = $connection->channel();
$channel->exchange_declare($config['exchange'], 'topic', false, false, false);
$routingKey = $argv[1];
$message = join(' ', array_splice($argv, 2));
$message = empty($message) ? 'Hello world!' : $message;

// Publish Message
$channel->basic_publish(new AMQPMessage( $message ), $config['exchange'], $routingKey);
echo " [x] Sent '$message' on routingKey $routingKey\n";
$channel->close();
$connection->close();
