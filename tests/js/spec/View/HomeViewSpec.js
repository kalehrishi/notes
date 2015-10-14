describe("In HomeView tests", function() {

	it ("should invoke the btnRegister click event.", function() {
	    spyEvent = spyOnEvent('#registerForm', 'click');
	    $('#registerForm').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#registerForm');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

  	it ("should invoke the btnReset click event.", function() {
	    spyEvent = spyOnEvent('#loginForm', 'click');
	    $('#loginForm').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#loginForm');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

	it("A function setLoginClickHandler have been called", function(done) {
		var homeView, dummyHandler = jasmine.createSpy();
		homeView = new Notes.HomeView();

		var spy = spyOn(homeView, "setLoginClickedHandler");
		homeView.setLoginClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});


	it("A function setRegisterClickHandler have been called", function(done) {
		var homeView, dummyHandler = jasmine.createSpy();
		homeView = new Notes.HomeView();

		var spy = spyOn(homeView, "setRegisterClickedHandler");
		homeView.setRegisterClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});
});