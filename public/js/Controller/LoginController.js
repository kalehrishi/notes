function LoginController() {

}
LoginController.prototype.init = function() {
    console.log("In init Function..");
    var loginView = new LoginView(
        this.setResetClickedHandler(function(e) {
            loginView.resetData();
        })
    );
};
LoginController.prototype.setResetClickedHandler = function(handler) {
    console.log("In onLogin Reset Clicked Handler..");

    var resetButton = document.getElementById('reset');
    resetButton.addEventListener("click", function(e) {
        handler(e);
    }, false);
}

function LoginView() {

    this.resetData = function() {
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
    }
}
$(function() {
    var loginController = new LoginController();
    loginController.init();
})