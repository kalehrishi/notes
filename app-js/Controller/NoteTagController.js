Notes.NoteTagsController = {
	noteTagView: null,
	init: function (userSelectedTag, userTagsArray) {

		this.noteTagView = new Notes.NoteTagView();
		this.noteTagView.create(userSelectedTag);
		
		this.noteTagView.setDeleteSelectedTagClickedHandler(userTagsArray, function (e, self,tagToBeDeleted) {
			console.log("deleteSelectedTag===",tagToBeDeleted);
			for (var i = 0; i < userTagsArray.length; i++) {
			
				if(tagToBeDeleted.tag === userTagsArray[i].tag)
				{
					userTagsArray.splice(i, 1);
				}
			}
		});
	}
};