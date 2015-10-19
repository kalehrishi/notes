Notes.CreateNoteView = function (backButtonClickedHandler) {
	
	this.create = function () {
		
        var template = $("#hiddenCreateNoteView").html();
        var data = {noteTitle: "Create New Note"};
        Notes.View.show(template, data);
	};

	this.setBackButtonClickedHandler = function (handler) {
    	console.log("In Back Button Clicked Handler");
    	
    	(function(self){
        var backButtonElement = document.getElementById("back");
    	console.log(backButtonElement);
        
        if (backButtonElement) {
            backButtonElement.addEventListener("click", function (e) {
            	console.log(e);
                handler(e, self);
            }, false);
        }
    })(this);
	};

	this.setBackButtonClickedHandler(backButtonClickedHandler);
};
