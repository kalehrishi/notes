function templateLoader (template) {
	$.ajax({url:template, async:false, success:function(template) {
  		console.log(template);
  		var rendered = Mustache.render(template, {});
  		$("body").append(rendered);
	}});
};