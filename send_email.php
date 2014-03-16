<?php

require 'vendor/autoload.php';

use Carrot\Consumer;

(new Consumer())
  ->bind('send_email', 'emails', '*.send')
  ->bind('send_email', 'sms', '*.sent')
  ->listenTo('send_email', function($msg){
      $message = json_decode($msg);
      mail('jasonlotito@gmail.com', 'MidwestPHP RabbitMQ Talk', $message->message);
      echo 'Message sent: ' . $message->message . PHP_EOL;
      return true;
  })->listenAndWait();
