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
});;Notes.notesController = {
    notesView: null,
    init: function () {
        this.notesView = new Notes.NotesView();
        this.notesView.show();
    }
};
;Notes.utils = {
    post: function (url, request, isAsync, onSuccess, onFailure) {
        var xhr = new XMLHttpRequest(), data = JSON.stringify(request);
        console.log(data);
        xhr.open("POST", url, isAsync);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log("OnXhr Success Response: ", response);
                if (response.status === 0) {
                    onFailure(response);
                } else {
                    onSuccess(response);
                }
            }
        };
    }
};;if (Notes === undefined) {
    var Notes = {};
}
;Notes.LoginView = function (resetClickedHandler, loginClickedHandler) {
    this.resetData = function () {
        console.log("in reset fun");
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
    };

    this.readUserData = function () {
        var id, firstName, lastName, createdOn, email, password;
        
        id = document.getElementById("id").value;
        firstName = document.getElementById("firstName").value;
        lastName = document.getElementById("lastName").value;
        createdOn = document.getElementById("createdOn").value;
        email = document.getElementById("email").value;
        password = document.getElementById("password").value;
        
        return {
            id: id,
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            createdOn: createdOn
        };
    };

    this.setLoginClickedHandler = function (handler) {
        console.log("In onLoginClickedHandler...");
        
        var loginButton = document.getElementById("login");
        loginButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
    };

    this.setResetClickedHandler = function (handler) {
        console.log("In onLogin Reset Clicked Handler..");
        
        var resetButton = document.getElementById("reset");
        if (resetButton) {
            resetButton.addEventListener("click", function (e) {
                handler(e);
            }, false);
        }
    };

    this.hide = function () {
        document.getElementById("container").style.display = "none";
    };

    this.showError = function (response) {
        var errorMessage = response.data;
        document.getElementById("errorMessage").innerText = errorMessage;
    };
    
    this.setLoginClickedHandler(loginClickedHandler);
    this.setResetClickedHandler(resetClickedHandler);
};
;Notes.NotesView = function () {
    this.show = function () {
        console.log("In notes View");
        window.location.href = "./notes";
    };
};
