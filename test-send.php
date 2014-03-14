<?php
require 'vendor/autoload.php';

use Carrot\Publisher;
$msg = implode(' ', array_splice($argv, 1));
(new Publisher('messages'))
  ->publish('message.new', $msg);
