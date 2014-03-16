var amqp = require('amqp');

var conn = amqp.createConnection();

conn.on('ready', function(){
  conn.queue('all-messages', function(q){
    q.bind('messages', '#');
    q.bind('emails', '#');
    q.bind('sms', '#');
    q.subscribe(function(msg){
      console.log(msg);
      return true;
    });
  });
});