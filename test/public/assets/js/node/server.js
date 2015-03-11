var io = require('socket.io').listen(3000);
//var moment = require("moment");
//var now = moment(new Date()); var date = now.format("YYYY MMM D HH:mm:s");
io.sockets.on('connection', function (socket) {
    socket.on('mensaje_cliente', function (mensaje) {
		var msg = JSON.parse(mensaje);
		var resp = JSON.stringify({"color":msg.color,"x":msg.x,"y":msg.y});
        io.sockets.emit("mensaje_servidor", resp);
    });
});
