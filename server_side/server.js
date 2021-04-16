//server
var express = require("express");
var app = express();
app.use(express.static("public"));
app.set("view engine", "ejs");
app.set("views", "./views");


var server = require("http").Server(app);
//socket:
var io = require("socket.io")(server, { cors: { origin: "http://127.0.0.1:80", methods: ["GET", "POST"], transports: ['websocket', 'polling'], credentials: true }, allowEIO3: true });
server.listen(80, { serveClient: true });

var mangUsers = [];
var usersTyping = [];
io.on("connection", function(socket) {
  socket.on("doanxem",function(data){
    console.log(data);
	socket.emit("sendsignal", "goodwork!");
  });
  
  socket.on("client-send-Username", function(data) {
    var temp = data;
    if (!temp.trim()) {
      socket.emit("server-send-dki-thatbai", null);
      return;
    }
    if (mangUsers.includes(data)) {
      socket.emit("server-send-dki-thatbai", data);
    } else {
      mangUsers.push(data);
      socket.Username = data;
      socket.emit("server-send-dki-thanhcong", data);
      io.sockets.emit("server-send-danhsach-Users", mangUsers);
    }
  });

  socket.on("logout",function(){
    logout(socket);
  });
  socket.on("disconnect",function(){
    logout(socket);
	});
  socket.on("user-send-message",function(data){
    io.sockets.emit("server-send-message",{un:socket.Username,nd: data})
  });
  socket.on("isTyping",function(data){
    if(data){
      usersTyping.push(socket.Username);
      io.sockets.emit("someoneistyping",usersTyping);
    }else{
      usersTyping.splice(usersTyping.indexOf(socket.Username),1);
      io.sockets.emit("someoneistyping",usersTyping);
    }
  });
});
app.get("/", function(req, res) {
  res.render("trangchu")
});
function logout(socket){
  if(mangUsers.includes(socket.Username)){
    mangUsers.splice(mangUsers.indexOf(socket.Username),1);
  }
  socket.broadcast.emit("server-send-danhsach-Users",mangUsers);
  usersTyping.forEach(function(index){
    if(usersTyping.includes(socket.Username)){
      usersTyping.splice(
        usersTyping.indexOf(socket.Username),1
      );
    };
  });
  io.sockets.emit("someoneistyping",usersTyping);
}
