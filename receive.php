<?php
require_once 'vendor/autoload.php';

use Carrot\Consumer;
$queue = 'new_messages';
$handler = function($msg){
  echo $msg, PHP_EOL;
  return true;
};
(new Consumer())->listenTo($queue, $handler)
  ->listenAndWait();
