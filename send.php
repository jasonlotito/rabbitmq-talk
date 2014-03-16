<?php
// Setup, $ php send.php whatever you want to send
require_once 'vendor/autoload.php';

use Carrot\Publisher;

$config = require('config.php');

if (!empty($_POST['comment'])) {
  $publisher = new Publisher('messages');
  $sendCount = (int) (isset($_POST['simulatedMessageCount']) ? $_POST['simulatedMessageCount'] : 1);

  $start = microtime(true);
  for($x = 0; $x<$sendCount; $x++){
    if(isset($_POST['simulateWork'])) {
      usleep(500000);
      $msg = ['comment' => $_POST['comment'] . " $x"];
      $publisher->eventuallyPublish('message.new', $msg);
    } else {
      $publisher->publish('message.new', ['comment' => $_POST['comment'] . " $x"]);
    }
  }

  $time = microtime(true) - $start;

  header("Location: send.php?s=1&t=$time");
  die();
}

if(isset($_GET['s']) && $_GET['s'] == 1){
  echo "<h2>Message sent in {$_GET['t']}.</h2>";
}

?>

<h1>Simple MQ Publisher</h1>

<form method="post">
  <label>Message Text to Send: <input name="comment" placeholder="type a message to send" type="text" value="This is text <?=time()?>"></label><br>
  <label>Simulated Message Count: <input type="number" name="simulatedMessageCount" value="1"></label><br>
  <label><input type="checkbox" name="simulateWork" value="1"/> Eventually Publish</label><br>
  <hr/>
  <button type="submit">Send Message</button>
</form>
