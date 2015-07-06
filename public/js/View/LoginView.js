/*jslint browser: true*/
/*global $, jQuery, alert, console, require, shortcut*/
"use strict";
function LoginView(resetClickedHandler, loginClickedHandler) {
    this.resetData = function () {
        console.log("in reset fun");
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    };

    this.readUserData = function () {
        var id, firstName, lastName, createdOn, email, password;
        id = document.getElementById('id').value;
        firstName = document.getElementById('firstName').value;
        lastName = document.getElementById('lastName').value;
        createdOn = document.getElementById('createdOn').value;
        email = document.getElementById('email').value;
        console.log(email);

        password = document.getElementById('password').value;
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

    this.setLoginClickedHandler = function (handler) {
       // console.log("In onLoginClickedHandler...");
        var loginButton = document.getElementById('login');
        loginButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
    };

    this.setResetClickedHandler = function (handler) {
        console.log("In onLogin Reset Clicked Handler..");
        var resetButton = document.getElementById('reset');
        resetButton.addEventListener("click", function (e) {
            handler(e);
        }, false);
    };

    this.hide = function () {
        document.getElementById('container').style.display = "none";
    };

    this.showError = function (response) {
        var errorMessage = response.data;
        alert(errorMessage);
    };
    /*this.show = function () {

    };*/
    this.setLoginClickedHandler(loginClickedHandler);
    this.setResetClickedHandler(resetClickedHandler);
}