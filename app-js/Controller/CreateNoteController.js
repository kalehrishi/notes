Notes.CreateNoteController = {
	createNoteView: null,

	init: function () {
		var userSelectedTagsArray = [];

		// call to UserTagsController
		Notes.UserTagsController.init();
		
		this.createNoteView = new Notes.CreateNoteView();
		this.createNoteView.create();

		this.createNoteView.setBackButtonClickedHandler(function (e, self) {
				Notes.NotesController.init();
			});
		
		this.createNoteView.setSaveButtonClickedHandler(function (e, self) {
			
			var notModel = self.readUserData(userSelectedTagsArray);
			console.log("notModel====",notModel);

			// call api for create Note
			Notes.utils.post("/notes/create", notModel, true, function (response) {
				console.log("OnSuccess Response:", response);
				Notes.NotesController.init();
        	},
        	function (response) {
            	console.log("OnFailure Response:", response);
            	self.showError(response);
        	});

		});
	}
};