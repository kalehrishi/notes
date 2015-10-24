Notes.NoteTagController = {
	noteTagView: null,
	init: function (userTagsArray) {

		this.noteTagView = new Notes.NoteTagView();
		this.noteTagView.create(userTagsArray);


		this.noteTagView.setDeleteSelectedTagClickedHandler(userTagsArray, function (e, self,deleteSelectedTag) {
			console.log("deleteSelectedTag===",deleteSelectedTag);
			var deletetag = deleteSelectedTag;

			for (var i = 0; i < userTagsArray.length; i++) {
			
				if(deletetag.tag === userTagsArray[i].tag)
				{
					userTagsArray.splice(i, 1);
					
					Notes.NoteTagController.init(userTagsArray);
				}
			}
		});
	}
};