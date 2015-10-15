Notes.CreateNoteController = {
	createNoteView: null,

	init: function () {
		this.createNoteView = new Notes.CreateNoteView();
		this.createNoteView.create();	
	}
};