Notes.NoteView = function () {
	
	this.create = function (response) {
		var noteViewtemplate = $("#hiddenNoteView").html();
		var noteModel = response.data;
		
		if(noteModel.noteTags.length === 0)
		{
			noteModel.noteTags = [{tag: "No Tags"}];
		}
		console.log("noteModel====",noteModel);
		
		new Notes.View.show(noteViewtemplate, noteModel);
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
};
