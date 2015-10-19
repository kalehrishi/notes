/*
 * @name Notes.loginController
*/
Notes.LoginController = {
    loginView: null,
    view: null,
    homeView: null,
    
    init: function () {
        console.log("In Login Controller init function");
        
        this.loginView = new Notes.LoginView();
        this.loginView.create();

        //assign reset clicked Handler
        this.loginView.setResetClickedHandler(function (e, self) {
                console.log(self);
                self.resetData();
            });

        //assign login clicked Handler
        this.loginView.setLoginClickedHandler(
            function (e, self) {
                console.log(e);
                
                //read data from View
                var userModel = self.readUserData();
                console.log("UserModel====",userModel);
                //call api
                Notes.utils.post("/api/session", userModel, true, function (response) {
                self.hide(response);
                console.log("OnSuccess Response:", response);
                
                //transfer control to notes controller
                Notes.NotesController.init();
                
            },
            function (response) {
                console.log("OnFailure Response:", response);
                self.showError(response);
            }
            );
        });

        //assign home clicked Handler
        this.loginView.setHomeClickedHandler(function (e, self) {
                Notes.HomeController.init();
            });
    }
};
