Notes.CreateNoteController = {
	createNoteView: null,
	userTagView: null,

	init: function () {
		var userTagView, noteTagView, userSelectedTagsArray = [];

		this.createNoteView = new Notes.CreateNoteView();
		this.createNoteView.create();
		
		userTagView  = Notes.UserTagsController.init(function (e, userSelectedTag) {
			console.log("userSelectedTag====",userSelectedTag);
			var checkTagExist = false;

			for (var i = 0; i < userSelectedTagsArray.length; i++) {
				if(userSelectedTagsArray[i].tag === userSelectedTag.tag) {
					checkTagExist = true;
					alert("Already Selected!!!");
					return;
				}
			}
			if(checkTagExist === false) {
				userSelectedTagsArray.push(userSelectedTag);
				noteTagView = Notes.NoteTagsController.init(userSelectedTag, userSelectedTagsArray);
				$("#noteTags").append(noteTagView);
			}
		});
		$("#userTags").append(userTagView);

		// get tag from text input
		this.createNoteView.setAddButtonClickedHandler(function (e, self, userSelectedTag) {
			userSelectedTagsArray.push(userSelectedTag);
			
			noteTagView = Notes.NoteTagsController.init(userSelectedTag, userSelectedTagsArray);
			$("#noteTags").append(noteTagView);
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
