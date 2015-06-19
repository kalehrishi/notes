var utils = {
    post: function(url, request, isAsync, onSuccess, onFailure) {
        var data = JSON.stringify(request);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, isAsync);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(data);

        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log("OnXhr Success Response: ", response);
                if (response.status == 0) {
                    onFailure(response);
                } else { 
                    onSuccess(response);
                }
            }
        }
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
            
            //call api
            utils.post('/api/session', userModel, true, function(response) {
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