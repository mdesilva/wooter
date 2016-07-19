var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis({password: 'a7KZY072UAllRaJ'});

redis.subscribe('broadcast');

redis.on('message', function(channel, message) {

    message = JSON.parse(message);

    console.log(message.event);
    console.log(message.data);

    if (message.data.user_id) {
        io.emit(channel + ':' + message.event + ':' + message.data.user_id, message);
    } else {
        io.emit(channel + ':' + message.event, message);
    }
});

server.listen(3000);
