Notes.RegisterController = {
	registerView: null,

	init: function () {
		console.log("in register init");
		
		this.registerView = new Notes.RegisterView();
		this.registerView.create();
        
        //assgin Event Clicked Handler
        this.registerView.setResetClickedHandler(function (e, self) {
			console.log("before reset call");
			self.resetData();
		});

		this.registerView.setRegisterClickedHandler(
			function (e, self) {
            console.log(e);
            
            //read data from View
            var userModel = self.readUserData();
        
            //call api
            Notes.utils.post("/register", userModel, true, function (response) {
	        console.log("OnSuccess Response:", response);
	            
	        //transfer control to login controller
	        Notes.loginController.init();
        },
        function (response) {
            console.log("OnFailure Response:", response);
            self.showError(response);
        });
		});


            /*,
            function (e, self) {
				console.log("before reset call");
				self.resetData();
			},
	        function (e, self) {
	            console.log(e);
	            
	            //read data from View
	            var userModel = self.readUserData();
	        
	            //call api
	            Notes.utils.post("/register", userModel, true, function (response) {
		        console.log("OnSuccess Response:", response);
		            
		        //transfer control to login controller
		        Notes.loginController.init();
	        },
	        function (response) {
	            console.log("OnFailure Response:", response);
	            self.showError(response);
	        });
			});*/
		/*this.registerView = new Notes.RegisterView(
			{
				title: "User Registration",
				test: "Registation Form"
			},
			function (e, self) {
				console.log("before reset call");
				self.resetData();
			},
	        function (e, self) {
	            console.log(e);
	            
	            //read data from View
	            var userModel = self.readUserData();
	        
	            //call api
	            Notes.utils.post("/register", userModel, true, function (response) {
		        console.log("OnSuccess Response:", response);
		            
		        //transfer control to login controller
		        Notes.loginController.init();
	        },
	        function (response) {
	            console.log("OnFailure Response:", response);
	            self.showError(response);
	        });
	        }
	    );/
	    this.registerView.show();*/
	}
};