/*
 * @name Notes.NotesView
*/
Notes.NotesView = function (logoutClickedHandler) {
	/*
	 * @method Function show() redirects to next notes api
	*/
    this.show = function () {
        console.log("In notes View");
        window.location.href = "./notes";
    };

    this.logout = function () {
    	console.log("in logout");
    	var template = $("#hiddenLoginView").html();
        var data = {"login": "Login Form"};
        
        Notes.LoginView.render(template, data);
    };

    this.setLogoutClickedHandler = function (handler) {
    	console.log("In logout Clicked Handler");
    	
    	(function(self){
        
        setTimeout(function() {
        
        var logoutElement = document.getElementById("logout");
    	console.log(logoutElement);
        
        if (logoutElement) {
            logoutElement.addEventListener("click", function (e) {
            	console.log(e);
                handler(e, self);
            }, false);
        }
    }, 6000);
    })(this);
	};

	this.setLogoutClickedHandler(logoutClickedHandler);
};