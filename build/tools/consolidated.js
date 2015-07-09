var utils = {
    post: function (url, request, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest(), data = JSON.stringify(request);
        xhr.open('POST', url, isAsync);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(data);

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                //console.log("OnXhr Success Response: ", response);
                if (response.status === 0) {
                    onFailure(response);
                } else {
                    onSuccess(response);
                }
            }
        };
    }
};

var loginController = {
    loginView: null,
    init: function () {
        this.loginView = new LoginView(function (e) {
            //console.log(e);
            loginController.loginView.resetData();
        }, function (e) {
            console.log(e);
            //read data from View
            var userModel = loginController.loginView.readUserData();
            //call api
            utils.post('/api/session', userModel, true, function (response) {
                loginController.loginView.hide(response);
                console.log("OnSuccess Response:", response);
                //transfer control to notes controller
                notesController.init();
            }, function (response) {
                console.log("OnFailure Response:", response);
                loginController.loginView.showError(response);
            });

        });
        //this.loginView.show();
    }
};
$(function () {
    loginController.init();
});var notesController = {
    notesView: null,
    init: function () {
        this.notesView = new NotesView();
        this.notesView.show();
    }
};function changeColor() {
    console.log("running animation");
    $('#content').animate({'color': '#FFFFFF'}, 5000);
} 

$(function() {
	$('#change').live('click', function(){
    changeColor();
	});
});
function LoginView(resetClickedHandler, loginClickedHandler) {
    this.resetData = function () {
        console.log("in reset fun");
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    };

    this.readUserData = function () {
        var id, firstName, lastName, createdOn, email, password;
        
        id = document.getElementById('id').value;
        firstName = document.getElementById('firstName').value;
        lastName = document.getElementById('lastName').value;
        createdOn = document.getElementById('createdOn').value;
        email = document.getElementById('email').value;
        password = document.getElementById('password').value;
        
        return {
            id: id,
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            createdOn: createdOn
        };
    };

    this.setLoginClickedHandler = function (handler) {
        console.log("In onLoginClickedHandler...");
        
        var loginButton = document.getElementById('login');
        loginButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
    };

    this.setResetClickedHandler = function (handler) {
        console.log("In onLogin Reset Clicked Handler..");
        
        var resetButton = document.getElementById('reset');
        if(resetButton) {
            resetButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
        }
    };

    this.hide = function () {
        document.getElementById('container').style.display = "none";
    };

    this.showError = function (response) {
        var errorMessage = response.data;
        alert(errorMessage);
    };
    /*this.show = function () {

    };*/
    this.setLoginClickedHandler(loginClickedHandler);
    this.setResetClickedHandler(resetClickedHandler);
}function NotesView() {
    'use strict';
    this.show = function () {
        console.log("In notes View");
        window.location.href = './notes';
    };
}
var utils = {
    post: function (url, request, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest(), data = JSON.stringify(request);
        xhr.open('POST', url, isAsync);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(data);

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                //console.log("OnXhr Success Response: ", response);
                if (response.status === 0) {
                    onFailure(response);
                } else {
                    onSuccess(response);
                }
            }
        };
    }
};

var loginController = {
    loginView: null,
    init: function () {
        this.loginView = new LoginView(function (e) {
            //console.log(e);
            loginController.loginView.resetData();
        }, function (e) {
            console.log(e);
            //read data from View
            var userModel = loginController.loginView.readUserData();
            //call api
            utils.post('/api/session', userModel, true, function (response) {
                loginController.loginView.hide(response);
                console.log("OnSuccess Response:", response);
                //transfer control to notes controller
                notesController.init();
            }, function (response) {
                console.log("OnFailure Response:", response);
                loginController.loginView.showError(response);
            });

        });
        //this.loginView.show();
    }
};
$(function () {
    loginController.init();
});var notesController = {
    notesView: null,
    init: function () {
        this.notesView = new NotesView();
        this.notesView.show();
    }
};function changeColor() {
    console.log("running animation");
    $('#content').animate({'color': '#FFFFFF'}, 5000);
} 

$(function() {
	$('#change').live('click', function(){
    changeColor();
	});
});
function LoginView(resetClickedHandler, loginClickedHandler) {
    this.resetData = function () {
        console.log("in reset fun");
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    };

    this.readUserData = function () {
        var id, firstName, lastName, createdOn, email, password;
        
        id = document.getElementById('id').value;
        firstName = document.getElementById('firstName').value;
        lastName = document.getElementById('lastName').value;
        createdOn = document.getElementById('createdOn').value;
        email = document.getElementById('email').value;
        password = document.getElementById('password').value;
        
        return {
            id: id,
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            createdOn: createdOn
        };
    };

    this.setLoginClickedHandler = function (handler) {
        console.log("In onLoginClickedHandler...");
        
        var loginButton = document.getElementById('login');
        loginButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
    };

    this.setResetClickedHandler = function (handler) {
        console.log("In onLogin Reset Clicked Handler..");
        
        var resetButton = document.getElementById('reset');
        if(resetButton) {
            resetButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
        }
    };

    this.hide = function () {
        document.getElementById('container').style.display = "none";
    };

    this.showError = function (response) {
        var errorMessage = response.data;
        alert(errorMessage);
    };
    /*this.show = function () {

    };*/
    this.setLoginClickedHandler(loginClickedHandler);
    this.setResetClickedHandler(resetClickedHandler);
}function NotesView() {
    'use strict';
    this.show = function () {
        console.log("In notes View");
        window.location.href = './notes';
    };
}
var utils={post:function(a,c,e,g,b){var f=new XMLHttpRequest(),d=JSON.stringify(c);f.open("POST",a,e);f.setRequestHeader("Content-Type","application/json");f.send(d);f.onreadystatechange=function(){if(f.readyState===4&&f.status===200){var h=JSON.parse(f.responseText);if(h.status===0){b(h)}else{g(h)}}}}};var loginController={loginView:null,init:function(){this.loginView=new LoginView(function(a){loginController.loginView.resetData()},function(b){console.log(b);var a=loginController.loginView.readUserData();utils.post("/api/session",a,true,function(c){loginController.loginView.hide(c);console.log("OnSuccess Response:",c);notesController.init()},function(c){console.log("OnFailure Response:",c);loginController.loginView.showError(c)})})}};$(function(){loginController.init()});var notesController={notesView:null,init:function(){this.notesView=new NotesView();this.notesView.show()}};function changeColor(){console.log("running animation");$("#content").animate({color:"#FFFFFF"},5000)}$(function(){$("#change").live("click",function(){changeColor()})});function LoginView(a,b){this.resetData=function(){console.log("in reset fun");document.getElementById("email").value="";document.getElementById("password").value=""};this.readUserData=function(){var h,f,e,g,d,c;h=document.getElementById("id").value;f=document.getElementById("firstName").value;e=document.getElementById("lastName").value;g=document.getElementById("createdOn").value;d=document.getElementById("email").value;c=document.getElementById("password").value;return{id:h,firstName:f,lastName:e,password:c,email:d,createdOn:g}};this.setLoginClickedHandler=function(d){console.log("In onLoginClickedHandler...");var c=document.getElementById("login");c.addEventListener("click",function(f){d(f)},false)};this.setResetClickedHandler=function(d){console.log("In onLogin Reset Clicked Handler..");var c=document.getElementById("reset");if(c){c.addEventListener("click",function(f){d(f)},false)}};this.hide=function(){document.getElementById("container").style.display="none"};this.showError=function(c){var d=c.data;alert(d)};this.setLoginClickedHandler(b);this.setResetClickedHandler(a)}function NotesView(){this.show=function(){console.log("In notes View");window.location.href="./notes"}};