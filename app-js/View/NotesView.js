/*
 * @name Notes.NotesView
*/
Notes.NotesView = function (response, logoutClickedHandler, createClickedHandler) {
	
    var responseData = response.data;
    var data = {
        create: "create",
        logout: "Logout",
        titles: responseData
    };
    var template = $("#hiddenNotesView").html();
    Notes.View.show(template, data);

    this.setLogoutClickedHandler = function (handler) {
    	console.log("In logout Clicked Handler");
    	
    	(function(self){
        var logoutElement = document.getElementById("logout");
    	console.log(logoutElement);
        
        if (logoutElement) {
            logoutElement.addEventListener("click", function (e) {
            	console.log(e);
                handler(e, self);
            }, false);
        }
    })(this);
	};

    this.setCreateNoteClickedHandler = function (handler) {
        console.log("In logout Clicked Handler");
        
        (function(self){
        var crateNoteElement = document.getElementById("create");
        console.log(crateNoteElement);
        
        if (crateNoteElement) {
            crateNoteElement.addEventListener("click", function (e) {
                console.log(e);
                handler(e, self);
            }, false);
        }
    })(this);
    };

    this.setLogoutClickedHandler(logoutClickedHandler);
    this.setCreateNoteClickedHandler(createClickedHandler);
};