Notes.UserTagsController = {
	userTagView: null,
	userTagViewTemplate: null,

	init: function (handler) {
		var selectedTag, userSelectedTagsArray = [],view;
		var userTagsContainer  = document.createElement("div");
		// get all tags from database
		Notes.utils.get("/notes/api/userTag", true,
			function (response) {
				console.log("OnSuccess Response:", response);
				
				var userTagsArray = response;
				console.log("api result of userTagsArray====",userTagsArray);

				this.userTagView = new Notes.UserTagView();
				var view = this.userTagView.create(userTagsArray);
				console.log("view===========",view);

				$(userTagsContainer).append(view);
				
				this.userTagView.setTagsClickedHandler(view, userTagsArray, handler);
			},
            function (response) {
                console.log("OnFailure Response:", response);
            });		
		return userTagsContainer;
	}
};