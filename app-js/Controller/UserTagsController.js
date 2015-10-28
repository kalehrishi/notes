Notes.UserTagsController = {
	userTagView: null,
	userTagViewTemplate: null,

	init: function (handler) {
		
		var userSelectedTagsArray = [];

		// get all tags from database
		Notes.utils.get("/notes/api/userTag", true,
			function (response) {
				console.log("OnSuccess Response:", response);
				
				var userTagsArray = response;
				console.log("api result of userTagsArray====",userTagsArray);

				this.userTagView = new Notes.UserTagView();
				var template = this.userTagView.create(userTagsArray);

				var liEleRef = document.getElementsByTagName("li");
            	
            	for (var i = 0; i < userTagsArray.length; i++) {

	                console.log("in for loop");
	                var userSelectTagEleRef = liEleRef[i];

	            	userSelectTagEleRef.setAttribute("value", JSON.stringify(userTagsArray[i]));
	            	console.log("userSelectTagEleRef===",userSelectTagEleRef);

	                if (userSelectTagEleRef) {
	                	userSelectTagEleRef.addEventListener("click", function (e) {
	                			console.log("after click assign...");
	                            var userSelectedTag = JSON.parse(e.target.getAttribute("value"));
	                            console.log("userSelectedTag===",userSelectedTag);

	                            handler(e, userSelectedTag);
	                        }, false);
	                }
	            }
	           
			},
            function (response) {
                console.log("OnFailure Response:", response);
            });	
	}
};