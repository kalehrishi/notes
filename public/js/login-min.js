var utils={post:function(a,c,e,g,b){var f=new XMLHttpRequest(),d=JSON.stringify(c);f.open("POST",a,e);f.setRequestHeader("Content-Type","application/json");f.send(d);f.onreadystatechange=function(){if(f.readyState===4&&f.status===200){var h=JSON.parse(f.responseText);if(h.status===0){b(h)}else{g(h)}}}}};var loginController={loginView:null,init:function(){this.loginView=new LoginView(function(a){loginController.loginView.resetData()},function(b){console.log(b);var a=loginController.loginView.readUserData();utils.post("/api/session",a,true,function(c){loginController.loginView.hide(c);console.log("OnSuccess Response:",c);notesController.init()},function(c){console.log("OnFailure Response:",c);loginController.loginView.showError(c)})})}};$(function(){loginController.init()});var notesController={notesView:null,init:function(){this.notesView=new NotesView();this.notesView.show()}};function LoginView(a,b){this.resetData=function(){console.log("in reset fun");document.getElementById("email").value="";document.getElementById("password").value=""};this.readUserData=function(){var h,f,e,g,d,c;h=document.getElementById("id").value;f=document.getElementById("firstName").value;e=document.getElementById("lastName").value;g=document.getElementById("createdOn").value;d=document.getElementById("email").value;c=document.getElementById("password").value;return{id:h,firstName:f,lastName:e,password:c,email:d,createdOn:g}};this.setLoginClickedHandler=function(d){console.log("In onLoginClickedHandler...");var c=document.getElementById("login");c.addEventListener("click",function(f){d(f)},false)};this.setResetClickedHandler=function(d){console.log("In onLogin Reset Clicked Handler..");var c=document.getElementById("reset");if(c){c.addEventListener("click",function(f){d(f)},false)}};this.hide=function(){document.getElementById("container").style.display="none"};this.showError=function(c){var d=c.data;alert(d)};this.setLoginClickedHandler(b);this.setResetClickedHandler(a)}function NotesView(){this.show=function(){console.log("In notes View");window.location.href="./notes"}};