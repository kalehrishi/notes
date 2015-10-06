Notes.homeController = {
    homeView: null,
    view: null,

    init: function() {
        this.homeView = new Notes.HomeView(
        	function(e, self) {
                var templateName = $("#hiddenRegisterView").html();
                var data = {
                    "title": "Registation Form"
                };

                this.view = new Notes.View();
                this.view.render(templateName, data);
            },
            function(e, self) {
            	//console.log("in homeController of second parameter");
            	Notes.loginController.init();
            }
        );
    }
};