Notes.loginController = {
    loginView: null,
    
    init: function () {
        this.loginView = new Notes.LoginView(function (e) {
            console.log(e);
            Notes.loginController.loginView.resetData();
        }, function (e) {
            console.log(e);
            //read data from View
            var userModel = Notes.loginController.loginView.readUserData();
            //call api

            Notes.utils.post("/api/session", userModel, true, function (response) {
                Notes.loginController.loginView.hide(response);
                console.log("OnSuccess Response:", response);
                //transfer control to notes controller
                Notes.notesController.init();
            }, function (response) {
                console.log("OnFailure Response:", response);
                Notes.loginController.loginView.showError(response);
            });

        });
        //this.loginView.show();
    }
};
$(function () {
    Notes.loginController.init();
});