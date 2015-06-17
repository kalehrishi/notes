function LoginController() {

}
LoginController.prototype.init = function() {
    console.log("In init Function..");

    var loginView = new LoginView();

    this.setResetClickedHandler(function(e) {
        loginView.resetData();
    });

    this.setLoginClickedHandler(function(e) {
        //read data from View
        var userModel = loginView.readUserData();
        console.log(userModel);


        //call api
        var loginModel = new LoginModel();

        var login = '/login';
        var response = loginModel.callApi(login, userModel, function(postCallbackData) {
            console.log(postCallbackData);

            if (postCallbackData.status == 0) {
                var OnLoginerror = loginModel.onFailure(userModel, postCallbackData);
                console.log(OnLoginerror);

                loginView.showError(OnLoginerror);
            } else {
                var onLoginSuccess = loginModel.onSuccess(userModel, postCallbackData);
                loginView.hide();
                console.log(onLoginSuccess);

                this.notesView = new NotesView();
                this.notesView.show(onLoginSuccess);
            }
        });
    });
};

LoginController.prototype.setLoginClickedHandler = function(handler) {
    console.log("In onLoginClickedHandler...");

    var loginButton = document.getElementById('login');

    loginButton.addEventListener("click", function(e) {
        handler(e);
    }, false);
}

LoginController.prototype.setResetClickedHandler = function(handler) {
    console.log("In onLogin Reset Clicked Handler..");

    var resetButton = document.getElementById('reset');
    resetButton.addEventListener("click", function(e) {
        handler(e);
    }, false);
}

$(function() {
    var loginController = new LoginController();
    loginController.init();
})