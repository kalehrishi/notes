Notes.NoteTagsView = function () {

	this.create = function (userSelectedTag) {
		var template, data, rendered, html;

		template = $("#hiddenNoteTagView").html();
		data = {
			tag: userSelectedTag.tag,
			selectedUserTag: JSON.stringify(userSelectedTag)};
        
       	rendered = Mustache.render(template, data);

        html = $.parseHTML(rendered);
		return html;
	};


	this.setDeleteSelectedTagClickedHandler = function (view, handler) {
		var tagToBeDeleted, deleteTagFromArray;
		for (var i = 0; i < view.length; i++) {
			if(view[i].nodeName === "LI") {
				var liElementRef = view[i];
				console.log("liElementRef===",liElementRef);
				if (liElementRef) {
        			
        			liElementRef.addEventListener("click", function (e) {
	        			console.log("e.target=====",e.target);
		                tagToBeDeleted = e.target.parentElement.parentElement;
	                    tagToBeDeleted.remove();

		                deleteTagFromArray = JSON.parse(e.target.getAttribute("value"));
	                    handler(e, deleteTagFromArray);
	                }, false);
	    		}
			}
		}
    };
};
