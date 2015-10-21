Notes.DeleteController = {

	init: function (noteId) {
		console.log("In NoteController init");
		
		if(confirm("Are you sure want to Delete A Note ??")) {
			console.log("Yesss");
			console.log("NoteId====",noteId);
			
			Notes.utils.delete("/note/delete/" + noteId, true, function (response) {
			console.log("OnSuccess Response:", response);
			
			Notes.NotesController.init();
            },
            function (response) {
                console.log("OnFailure Response:", response);
                
            });
		} else {
			console.log("Noooo");
		}
	}
};