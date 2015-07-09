describe("A Click Event", function() {
  it ("is test with Reset button.", function() {
    var spyEvent;
    spyEvent = spyOnEvent('#reset1', 'click');
    $('#reset1').trigger( "click" );
       
    expect('click').toHaveBeenTriggeredOn('#reset1');
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
describe("Session Object", function(){
  var spy, loginView, email;
    beforeEach(function() {
        loginView = new LoginView();
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