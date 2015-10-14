Notes.View = {
	show: function (template, data) {
		console.log("In Show View");
		var rendered = Mustache.render(template, data);
        
        $("#content").html(rendered);
	}
};
