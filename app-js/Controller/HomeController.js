Notes.HomeController = {
    homeView: null,
    view: null,

    init: function() {
        console.log("in home HomeController");
        this.homeView = new Notes.HomeView(
        	function(e, self) {
                console.log("call to RegisterController");
                Notes.RegisterController.init();
            },
            function(e, self) {
            	Notes.loginController.init();
            }
        );
    }
};