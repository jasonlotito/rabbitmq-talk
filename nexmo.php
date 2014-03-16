<?php

require 'vendor/autoload.php';

use Carrot\Consumer;
use Carrot\Publisher;

$key = $argv[1];
$secret = $argv[2];
$phoneNumber = $argv[3];

$queueName = 'messages_for_nexmo';

$publisher = new Publisher('sms');

(new Consumer())
  ->bind($queueName, 'messages', 'message.new')
  ->listenTo($queueName, function($msg) use($key, $secret, $phoneNumber, $publisher) {
      $msg = json_decode($msg);
      $urlString = 'https://rest.nexmo.com/sms/json?api_key=%s&api_secret=%s' .
        '&from=17088568489&to=%s&text=%s';
      $preparedMessage = urlencode($msg->comment);
      $url = sprintf($urlString, $key, $secret, $phoneNumber, $preparedMessage);
//      $res = file_get_contents($url);
//      $result = json_decode($res);
//      $messageResult = $result->messages[0];
      $messageResult = (object) ['status' => '0'];
      echo "Message Result: " .
        ($messageResult->status === '0' ? 'Message Sent' : 'Message not sent')
        . PHP_EOL;
      $successful = $messageResult->status === '0';

      if ($successful) {
        $publisher->publish('sms.sent', ['message' => $msg->comment]);
      }

      return true; // up in the air $successful;
})->listenAndWait();
