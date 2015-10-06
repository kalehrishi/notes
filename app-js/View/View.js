Notes.View = function () {
	this.render = function (template, data) {
		
		console.log("In render function");
        Mustache.parse(template);
        var rendered = Mustache.render(template, data);
        document.body.innerHTML = rendered;
	};
};