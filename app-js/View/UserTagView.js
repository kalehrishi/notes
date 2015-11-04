Notes.UserTagView = function () {

	this.create = function (userTagsArray) {
		var data, template, rendered;
		data = {
			userTags: userTagsArray
		};
		console.log("data=====",data);

		template = $("#hiddenUserTagsView").html();
		rendered = Mustache.render(template, data);
       	console.log("rendered===",rendered);

       	var html = $.parseHTML(rendered);
       	
		return html;
	};

	this.setTagsClickedHandler = function (view, userTagsArray, handler) {
		console.log("in tag clicked handler.....");
		console.log("clicked handler in view=====",view);
		var j=0;
		for (var i = 0; i < view.length; i++) {
			if(view[i].nodeName === "LI") {
				var liElementRef = view[i];

				console.log("liElementRef===",liElementRef);
				if (liElementRef) {
					liElementRef.setAttribute("value", JSON.stringify(userTagsArray[j]));

					liElementRef.addEventListener("click", function (e) {
						console.log("after click assign...");
	                    var userSelectedTag = JSON.parse(e.target.getAttribute("value"));
	                    console.log("userSelectedTag===",userSelectedTag);

	                    handler(e, userSelectedTag);
	                }, false);
				}
				j++;
			}
		}	
	};
};


