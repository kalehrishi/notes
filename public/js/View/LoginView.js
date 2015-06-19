function LoginView(loginClickedHandler, resetClickedHandler) {


    this.resetData = function() {
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    };

    this.readUserData = function() {
        var id = document.getElementById('id').value;
        var firstName = document.getElementById('firstName').value;
        var lastName = document.getElementById('lastName').value;
        var createdOn = document.getElementById('createdOn').value;
        var email = document.getElementById('email').value;
        console.log(email);

        var password = document.getElementById('password').value;
        console.log(password);

        return {
            id: id,
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            createdOn: createdOn
        };
    };

    this.setLoginClickedHandler = function(handler) {
        console.log("In onLoginClickedHandler...");
        var loginButton = document.getElementById('login');

        loginButton.addEventListener("click", function(e) {
            handler(e);
        }, false);
    };

    this.setResetClickedHandler = function(handler) {
        console.log("In onLogin Reset Clicked Handler..");
        var resetButton = document.getElementById('reset');
        resetButton.addEventListener("click", function(e) {
            handler(e);
        }, false);
    };

    this.hide = function() {
        document.getElementById('container').style.display = "none";
    };

    this.showError = function(errorMessage) {
        console.log(errorMessage);
        alert(errorMessage.errorMsg);
    };
    this.show=function(){

    };
    this.setLoginClickedHandler(loginClickedHandler);
    this.setResetClickedHandler(resetClickedHandler);

}