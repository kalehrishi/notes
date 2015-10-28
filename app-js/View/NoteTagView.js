Notes.NoteTagView = function () {

	this.create = function (userSelectedTagsArray) {

		var template = $("#hiddenNoteTagView").html();
		var data = {selectedUserTags: userSelectedTagsArray};
        
       	var rendered = Mustache.render(template, data);

        $("#noteTags").html(rendered);
	};


	this.setDeleteSelectedTagClickedHandler = function (userTagsArray, handler) {
		(function(self){
			if(userTagsArray.length > 0) {
			for (var i = 0; i< userTagsArray.length; i++) {
				var tagToBeDeleted, anchorEleRef, deleteTagFromArray, tagToBedeleted,
				id = "del_"+i;
		       	anchorEleRef = document.getElementsByTagName("a")[i];
		        anchorEleRef.setAttribute("value", JSON.stringify(userTagsArray[i]));

		        if (anchorEleRef) {
		            anchorEleRef.addEventListener("click", function (e) {
		                tagToBeDeleted = e.target.parentElement.parentElement;
	                    tagToBeDeleted.remove();

		                deleteTagFromArray = JSON.parse(e.target.getAttribute("value"));
	                    handler(e, self, deleteTagFromArray);
		            }, false);
		        }
	        }
    	}
        })(this);
    };
};
