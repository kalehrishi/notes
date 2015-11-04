Notes.NoteTagsController = {
	noteTagView: null,
	init: function (userSelectedTag, userTagsArray) {
		var noteTagsContainer  = document.createElement("div");

		this.noteTagsView = new Notes.NoteTagsView();
		var view = this.noteTagsView.create(userSelectedTag);
		
		console.log("note ta view====",view);
		
		this.noteTagsView.setDeleteSelectedTagClickedHandler(view, function (e, tagToBeDeleted) {
			console.log("deleteSelectedTag===",tagToBeDeleted);
			for (var i = 0; i < userTagsArray.length; i++) {
				if(tagToBeDeleted.tag === userTagsArray[i].tag)
				{
					userTagsArray.splice(i, 1);
				}
			}
		});
		$(noteTagsContainer).append(view);
		return noteTagsContainer;
	}
};
