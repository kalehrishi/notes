describe("A Click Event", function() {
  it ("is test with Reset button.", function() {
    var spyEvent;
    spyEvent = spyOnEvent('#reset', 'click');
    $('#reset').trigger( "click" );
       
    expect('click').toHaveBeenTriggeredOn('#reset');
    expect(spyEvent).toHaveBeenTriggered();
  });


  it ("is test with Login button.", function() {
    var spyEvent;
    spyEvent = spyOnEvent('#login', 'click');
    $('#login').trigger( "click" );
       
    expect('click').toHaveBeenTriggeredOn('#login');
    expect(spyEvent).toHaveBeenTriggered();
  });

});

describe("A Function readUserData", function(){
  var loginView, email;
    beforeEach(function() {
        loginView = new Notes.LoginView();
    });

    it("is return empty object without click event.", function() {
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
});
