function LoginView() {

    this.resetData = function() {
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    }

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
    }

    this.hide = function() {
        document.getElementById('container').style.display = "none";
    }

    this.showError = function(errorMessage) {
        console.log(errorMessage);
        alert(errorMessage.errorMsg);
    }
}