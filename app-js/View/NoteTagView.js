Notes.NoteTagsView = function () {

	this.create = function (userSelectedTag) {
		var template, data, rendered, html;

		template = $("#hiddenNoteTagView").html();
		data = {selectedUserTag: userSelectedTag};
        
       	rendered = Mustache.render(template, data);

        html = $.parseHTML(rendered);
		$("#noteTags").append(html);
	};


	this.setDeleteSelectedTagClickedHandler = function (userTagsArray, handler) {
		(function(self){
			if(userTagsArray.length > 0) {
			for (var i = 0; i< userTagsArray.length; i++) {
				var tagToBeDeleted, anchorEleRef, deleteTagFromArray, tagToBedeleted,
				id = "del_"+i;
		       	anchorEleRef = document.getElementsByTagName("a")[i];

		       	anchorEleRef.setAttribute("value", JSON.stringify(userTagsArray[i]));
		        console.log("anchorEleRef====",anchorEleRef);

		        if (anchorEleRef) {
		            anchorEleRef.addEventListener("click", function (e) {
		            	console.log("e.target=====",e.target);
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
