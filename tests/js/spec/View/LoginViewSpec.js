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
describe("Object", function(){
  var spy;
    var loginView;
    var email;
    beforeEach(function() {
        loginView = new LoginView();
    });
    it("return session object", function() {
      var object  = {
            id: "",
            firstName: "",
            lastName: "",
            password: "",
            email: "",
            createdOn: ""
        };
      var result = loginView.readUserData();
      expect(object).toEqual(result);
    });
});


