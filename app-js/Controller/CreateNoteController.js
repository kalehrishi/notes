Notes.CreateNoteController = {
	createNoteView: null,
	
	init: function () {
		var userSelectedTagsArray = [];

		// Show Create View 
		this.createNoteView = new Notes.CreateNoteView();
		this.createNoteView.create();

		// call to UserTagsController
		Notes.UserTagsController.init(function (e, userSelectedTag) {
			
			for (var i = 0; i < userSelectedTagsArray.length; i++) {
				if(userSelectedTagsArray[i].tag === userSelectedTag.tag)
				{
					alert("You have already selected...");
					userSelectedTagsArray.splice(i, 1);
				}
			}
			userSelectedTagsArray.push(userSelectedTag);
			Notes.NoteTagsController.init(userSelectedTagsArray);
		});

		// get tag from text input
		this.createNoteView.setAddButtonClickedHandler(function (e, self, userSelectedTag) {
			userSelectedTagsArray.push(userSelectedTag);
			
			Notes.NoteTagsController.init(userSelectedTagsArray);
		});

		this.createNoteView.setBackButtonClickedHandler(function (e, self) {
				Notes.NotesController.init();
		});

		this.createNoteView.setSaveButtonClickedHandler(function (e, self) {
			
			var noteModel;

			noteModel = self.getInputValues(userSelectedTagsArray);
			console.log("notModel====",noteModel);

			// call api for create Note
			Notes.utils.post("/notes/create", noteModel, true, function (response) {
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