<?php
// Setup, $ php send.php whatever you want to send
require_once 'vendor/autoload.php';
$config = require('config.php');
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Message Prep
$connection = new AMQPConnection($config['mq']['host'],
  $config['mq']['port'],
  $config['mq']['user'],
  $config['mq']['pass']);

$channel = $connection->channel();
$message = join(' ', array_splice($argv, 1));
$message = empty($message) ? 'Hello world!' : $message;

// Publish Message
$channel->basic_publish(new AMQPMessage( $message ), '', 'hello');
echo " [x] Sent '$message'\n";
$channel->close();
$connection->close();
