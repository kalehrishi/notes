Notes.NoteView = function (response) {
	
	var noteViewtemplate = $("#hiddenNoteView").html();
	var noteModel = response.data;
	if(noteModel.noteTags.length === 0)
	{
		noteModel.noteTags = [{tag: "No Tags"}];
	}
	
	new Notes.View.show(noteViewtemplate, noteModel);
};