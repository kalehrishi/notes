function templateLoader(templateUrl) {
       $.ajax({url:templateUrl, async:false, success:function(container) {
                var rendered = Mustache.render(container, {});
                document.body.innerHTML = rendered;
        },
        error:function(e){
        	console.log(JSON.stringify(e));
        	console.log("Fail XHR");
	}});
}

$(function() {
        var templateUrl = "public/templates/template.mustache";
        templateLoader(templateUrl);
});
