describe("A Click Event", function() {
  it ("is test with Reset button.", function() {
    var spyEvent;
    spyEvent = spyOnEvent("#reset", "click");
    $("#reset").trigger( "click" );
       
    expect("click").toHaveBeenTriggeredOn("#reset");
    expect(spyEvent).toHaveBeenTriggered();
  });

  it ("is test with Login button.", function() {
    var spyEvent;
    spyEvent = spyOnEvent("#login", "click");
    $("#login").trigger( "click" );
       
    expect("click").toHaveBeenTriggeredOn("#login");
    expect(spyEvent).toHaveBeenTriggered();
  });
});

describe("In LoginView tests", function(){
  var loginView;
    beforeEach(function() {
        loginView = new Notes.LoginView();
      });

    it("A function readUserData is return empty object without click event.", function() {
     var loginView;
     loginView = new Notes.LoginView();
     var result, object  = {
            id: "",
            firstName: "",
            lastName: "",
            password: "",
            email: "",
            createdOn: ""
        };
    result = loginView.readUserData();
    
    expect(object).toEqual(result);
    });

    it("A function hide should result in form contanier being hidden", function() {
        loginView.hide();
        
        expect($( "#container" )).toBeHidden();
    });

    it("A function showError should show error message on failure login", function() {
        var response = {"status":0,"message":"FAILURE","version":"1.0.0","data":"Can Not Found Given Model In Database","debugData":null};
        loginView.showError(response);
        
        expect($( "#errorMessage" )).toHaveText("Can Not Found Given Model In Database");
    });

    it("A function resetData should reset values of email and password", function() {
        var email = document.getElementById("email");
        email.value = "gau@bhapkar.com";
        
        var password = document.getElementById("password");
        password.value = "Gauri@123";
        
        loginView.resetData();
        
        expect(email).toBeEmpty();
        expect(password).toBeEmpty();
    });
    
    it("A function setResetClickHandler have been called", function(done) {
      var dummyHandler = jasmine.createSpy();
      
      var spy = spyOn(loginView, "setResetClickedHandler");
      loginView.setResetClickedHandler(dummyHandler);
      
      expect(spy).toHaveBeenCalled();
      done();
    });

    it("A function setLoginClickedHandler have been called", function(done) {
      var dummyHandler = jasmine.createSpy();
      
      var spy = spyOn(loginView, "setLoginClickedHandler");
      loginView.setLoginClickedHandler(dummyHandler);
      
      expect(spy).toHaveBeenCalled();
      done();
    });
});
