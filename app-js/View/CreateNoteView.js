Notes.CreateNoteView = function () {
	
	this.create = function () {
		
        var template = $("#hiddenCreateNoteView").html();
        var data = {noteTitle: "Create New Note"};
        Notes.View.show(template, data);
	};
}