Notes.UserTagsController = {

	init: function () {
		userTagView: null,

		// get all tags from database
		Notes.utils.get("/notes/api/userTag", true,
			function (response) {
				console.log("OnSuccess Response:", response);
				
				var userTagsArray = response;
				console.log("api result of userTagsArray====",userTagsArray);

				this.userTagView = new Notes.UserTagView();
				this.userTagView.create(userTagsArray);
				
			},
            function (response) {
                console.log("OnFailure Response:", response);
            });	
	}
};