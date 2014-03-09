<?php

return [
  'exchange' => 'message',
  'type' => 'topic',
  'queue' => 'log',
  'consumer-tag' => 'midwest-consumer',
  'mq' => [
    'host' => 'localhost',
    'port' => 5672,
    'user' => 'guest',
    'pass' => 'guest'
  ]
];
