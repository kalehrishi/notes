console.log("in templateLoader.js");

function templateLoader(templateUrl) {
       $.ajax({url:templateUrl, async:false, success:function(container) {
                var rendered = Mustache.render(container, {});
                console.log(rendered);
                
                var div = document.createElement("div");
                div.id = "content";
                div.innerHTML = rendered;
                $('body').append(div);
        },
        error:function(e){
            console.log(JSON.stringify(e));
            console.log("Fail XHR");
    }});
}

$(function() {

        var templateUrl = "public/templates/hidden.mustache";
        templateLoader(templateUrl);

        var templateUrl = "public/templates/home.mustache";
        templateLoader(templateUrl);
        
        var templateUrl = "public/templates/register.mustache";
        templateLoader(templateUrl);

        var templateUrl = "public/templates/login.mustache";
        templateLoader(templateUrl);
});