Notes.NoteController = {
	noteView: null,

	init: function (noteId) {
		console.log("In NoteController init");
		
		Notes.utils.get("/note/read/" + noteId, true, function (response) {
			console.log("OnSuccess Response:", response);
			this.noteView = new Notes.NoteView(response);
            },
            function (response) {
                console.log("OnFailure Response:", response);
                this.noteView = new Notes.NoteView(response);
            });
	}
};