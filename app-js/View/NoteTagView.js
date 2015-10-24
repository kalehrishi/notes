Notes.NoteTagView = function () {

	this.create = function (userTagsArray) {
		var template = $("#hiddenNoteTagView").html();
		var data = {userTags: userTagsArray};
        
       	var rendered = Mustache.render(template, data);

        $("#noteTags").html(rendered);
	};


	this.setDeleteSelectedTagClickedHandler = function (userTagsArray, handler) {
		(function(self){
			if(userTagsArray.length > 0) {
				for (var i = 0; i< userTagsArray.length; i++) {
					var id = "del_"+i;
		          	var anchorEleRef = document.getElementsByTagName("a")[i];
		          	console.log("a==",anchorEleRef);
		          
		          	anchorEleRef.setAttribute("id", id);
		            var deleteTagEleRef = document.getElementById(id);

		          	console.log(deleteTagEleRef);

		          	deleteTagEleRef.setAttribute("value", JSON.stringify(userTagsArray[i]));
		          	if (deleteTagEleRef) {
		                deleteTagEleRef.addEventListener("click", function (e) {
		                	console.log("e.target======",e.target);
	                    	var deletedTag = JSON.parse(e.target.getAttribute("value"));
	                    	
	                    	handler(e, self,deletedTag);
		                }, false);
		            }
	        	}
    		}
        })(this);
    };
};
