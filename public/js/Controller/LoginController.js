var utils = {
    post: function(url, request, isSync, onSuccess, onFailure) {

    },
    get: function(url, request, isSync, onSuccess, onFailure) {

    }
}

var loginController = {
    loginView: null,
    init: function() {
        this.loginView = new LoginView(function(e) {
            loginController.loginView.resetData();
        }, function(e) {
            //read data from View
            var userModel = loginController.loginView.readUserData();
            console.log(userModel);

            //call api
            var loginModel = new LoginModel();

            var login = '/api/session';

            var Request = new Request(userModel);

            utils.post('/api/session', request, function(response) {
                loginController.loginView.hide(response);
                console.log("OnSuccess Response:", response);
                //transfer control to notes controller
                notesController.init();
            }, function(response) {
                console.log("OnFailure Response:", response);
                loginController.loginView.showError(response);
            });

        });
        this.loginView.show();
    }
}

$(function() {
    loginController.init();
})