Notes.CreateNoteController = {
	createNoteView: null,

	init: function () {
		var userSelectedTagsArray = [];

		// get all tags from database
		Notes.utils.get("/notes/api/userTag", true,
			function (response) {
				console.log("OnSuccess Response:", response);
				
				var userTagsArray = response;
				console.log("api result of userTagsArray====",userTagsArray);

				this.createNoteView = new Notes.CreateNoteView();
				this.createNoteView.create(userTagsArray);

				// select tag from UserTagsList 
				this.createNoteView.setUserTagsClickedHandler(userTagsArray, function (e, self, userSelectedTag) {
				for (var i = 0; i < userSelectedTagsArray.length; i++) {
					if(userSelectedTagsArray[i].tag === userSelectedTag.tag)
					{
						alert("You have already selected...");
						userSelectedTagsArray.splice(i, 1);
					}
				}
				userSelectedTagsArray.push(userSelectedTag);
				
				Notes.NoteTagController.init(userSelectedTagsArray);
			});

			// get tag from text input
			this.createNoteView.setAddButtonClickedHandler(function (e, self, userSelectedTag) {
				userSelectedTagsArray.push(userSelectedTag);
				
				Notes.NoteTagController.init(userSelectedTagsArray);
			});

			
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

			},
            function (response) {
                console.log("OnFailure Response:", response);
            });
	}
};