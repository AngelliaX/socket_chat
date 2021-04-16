var socket = io("127.0.0.1")

socket.on("server-send-dki-thatbai", function(data) {
  if(data == null){
    alert("Hãy nhập tên vào!");
    return;
  }
  alert("Có người đang dùng tên này, " + "hãy thử: "+ data + Math.floor(Math.random() * 1000))
});

socket.on("server-send-danhsach-Users",function(data){
  $("#boxContent").html("");
  data.forEach(function(i){
    $("#boxContent").append("<div class = 'user'>"+ i + "</div>");
  });

});

socket.on("server-send-dki-thanhcong", function(data) {
  $("#currentUser").html(data);
  $("#loginForm").hide(2000);
  $("#chatForm").show(1000);
});

var line = 0;
socket.on("server-send-message", function(data) {
  if(line >=11){
    $("#listMessage").html("");
    line = 0;
  }
  $("#listMessage").append("<div class = 'ms'>"+data.un+": "+data.nd);
  line++;
});
socket.on("someoneistyping",function(data){
  if(data.length != 0){
    var names = data.toString();
    $("#thongbao").html("<img width ='50px' height = '20px' src= 'typing.gif'> " + names + " is typing");
  }else{
    $("#thongbao").html("");
  }
});
$(document).ready(function() {
  $("#chatForm").hide();
  $("#loginForm").show();

  $("#btnRegister").click(function() {
    socket.emit("sendsignal", "goodwork!");
	//alert("socket.emit('sendsignal', 'goodwork!');");
  });
  $("#btnLogout").click(function() {
    socket.emit("logout");
    $("#loginForm").show(2000);
    $("#chatForm").hide(1000);
  });
  $("#txtMessage").focusin(function(){
    socket.emit("isTyping",true);
  });
  $("#txtMessage").focusout(function(){
    socket.emit("isTyping",false);
  });
  $("#btnSendMessage").click(function() {
    sendMsg();
  });
  $(document).keyup(function (e) {
    if ($("#txtMessage").is(":focus") && e.keyCode === 13) {
      sendMsg();
    }
    if ($("#txtUsername").is(":focus") && e.keyCode === 13) {
      login();
    }
 });
});
function sendMsg() {
  var msg = $("#txtMessage").val();
  if (!msg.trim()) {
    return;
  }
  socket.emit("user-send-message",msg);
  document.getElementById("txtMessage").value = '';
}
function login(){
  socket.emit("client-send-Username", $("#txtUsername").val().toLowerCase());
}
