Notes.HomeView = function (registerClickedHandler, loginClickedHandler) {
	
	this.create = function () {
		var templateName = $("#hiddenHomeView").html();
	    this.view = new Notes.View();
	    this.view.render(templateName, {});
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

	this.setRegisterClickedHandler(registerClickedHandler);
    this.setLoginClickedHandler(loginClickedHandler);
};