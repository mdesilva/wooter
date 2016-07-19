var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

io.sockets.on('connection', function(socket){
  console.log('a user connected');
  
  socket.on('inbox', function(inbox_id){
      console.log('inbox id: ', + inbox_id);
      socket.join('inbox_' + inbox_id);
  });
  
  socket.on('mail', function(msg){
    console.log('message: ' + msg.message.message);
    msg.inbox_ids.forEach(function(id){
        io.sockets.in('inbox_' + id).emit(msg.mail_type, msg);
    });
  });
  
  socket.on('player', function(player_id){
      console.log('player :', player_id);
      socket.join('player_' + player_id);
  });
  
  socket.on('player_notification', function(notification){
      console.log('notification :' + notification.notification);
      notification.player_ids.forEach(function(id){
          io.sockets.in('player_' + id).emit('notify_player', notification.notification);
      });
  });
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});