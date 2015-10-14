Notes.HomeView = function () {
	
	this.create = function () {
		
        var template = $("#hiddenHomeView").html();

        var data = {
                    h1: "Wel-come to Sticky-notes",
                    register: "New User:Register",
                    login: "Login"
                };

        Notes.View.show(template, data);
	};

	this.setRegisterClickedHandler = function (handler) {
		console.log("In onLoginClickedHandler...");       
    	(function(self){
		
		var register = document.getElementById("registerForm");
        if(register) {
            register.addEventListener("click", function (e) {
                handler(e, self);
            }, false);
        }
    	})(this);
    };

    this.setLoginClickedHandler = function (handler) {
		console.log("In onLoginClickedHandler...");       
    	(function(self){
		
		var login = document.getElementById("loginForm");
        
        if(login) {
            login.addEventListener("click", function (e) {
                handler(e, self);
            }, false);
        }
    	})(this);
    };
};