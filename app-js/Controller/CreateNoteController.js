Notes.CreateNoteController = {
	createNoteView: null,

	init: function () {
		this.createNoteView = new Notes.CreateNoteView();
		this.createNoteView.create();

		this.createNoteView.setBackButtonClickedHandler(function (e, self) {
			Notes.BackController.init();
		});
	}
};