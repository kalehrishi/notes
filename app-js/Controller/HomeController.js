Notes.HomeController = {
    homeView: null,

    init: function() {
        console.log("in home HomeController");
        var homeContent = document.getElementById("homeContent");

        this.homeView = new Notes.HomeView();
        if(homeContent === null) {
            //Create HomeView
            this.homeView.create();
        }

        this.homeView.setRegisterClickedHandler(
            function(e, self) {
            console.log("call to RegisterController");
            Notes.RegisterController.init();
        });

        this.homeView.setLoginClickedHandler(
            function(e, self) {
            Notes.loginController.init();
        });
        
    }
};