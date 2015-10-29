Notes.UserTagView = function () {

	this.create = function (userTagsArray) {
		var data, template, rendered;
		data = { userTags: userTagsArray };
		
		template = $("#hiddenUserTagsView").html();
		
		rendered = Mustache.render(template, data);
       	console.log("rendered===",rendered);

       	var html = $.parseHTML(rendered);
		$("#userTags").append(html); 	
	};
};