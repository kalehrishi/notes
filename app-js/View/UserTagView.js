Notes.UserTagView = function () {

	this.create = function (userTagsArray) {
		var template = $("#hiddenUserTagsView").html();
		var data = {userTags: userTagsArray};
        console.log("data===",data);
       	var rendered = Mustache.render(template, data);
       	console.log("rendered===",rendered);

       	$("#userTags").html(rendered);
	};
}