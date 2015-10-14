describe("In RegisterView tests", function() {
    
    it("Reset User entered input", function() {
        var firstName, lastName, email, password;

        var registerView = new Notes.RegisterView();    
        
        firstName = document.getElementById('firstName');
        firstName.value = "gauri";
        
        lastName = document.getElementById('lastName');
        lastName.value = "gauri";

        email = document.getElementById('email');
        email.value = "gauri";

        password = document.getElementById('password');
        password.value = "gauri";

        registerView.resetData();
        
        expect(firstName).toBeEmpty();
        expect(lastName).toBeEmpty();
        expect(email).toBeEmpty();
        expect(password).toBeEmpty();
    });

    it("A function readUserData is return empty object without click event.", function() {
        var registerView;
        registerView = new Notes.RegisterView();
        var expected, actual = {
            firstName: "",
            lastName: "",
            email: "",
            password: ""
            
        };
        expected = registerView.readUserData();

        expect(actual).toEqual(expected);
    });

    it("A function setResetClickedHandler have been called", function(done) {
        var registerView, dummyHandler = jasmine.createSpy();
        registerView = new Notes.RegisterView();

        var spy = spyOn(registerView, "setResetClickedHandler");
        registerView.setResetClickedHandler(dummyHandler);

        expect(spy).toHaveBeenCalled();
        done();
    });

    it("A function setRegisterClickedHandler have been called", function(done) {
        var registerView, dummyHandler = jasmine.createSpy();
        registerView = new Notes.RegisterView();

        var spy = spyOn(registerView, "setRegisterClickedHandler");
        registerView.setRegisterClickedHandler(dummyHandler);

        expect(spy).toHaveBeenCalled();
        done();
    });

    it("Show Error on Invalid Email and Password", function() {
        var registerView, response = {
            "status": 0,
            "message": "FAILURE",
            "version": "1.0.0",
            "data": "Invalid Email",
            "debugData": null
        };
        registerView = new Notes.RegisterView();

        registerView.showError(response);

        expect($("#errormsg")).toHaveText("Invalid Email");
    });
});