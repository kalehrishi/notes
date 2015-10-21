Notes.LogoutController = {
	init: function () {
		Notes.utils.get("/logout", true, function (response) {
			console.log("OnSuccess Response:", response);
			
			Notes.LoginController.init();
            },
            function (response) {
                console.log("OnFailure Response:", response);
                var errorMsg = response.data;
                alert(errorMsg);
            });
	}
};
