Notes.HomeView = function () {
	
	this.create = function () {
		var template = $("#hiddenHomeView").html();
        Mustache.parse(template);
        var rendered = Mustache.render(template, {});
        
        this.view = new Notes.View();
	    this.view.show(rendered);
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