describe("In HomeView tests", function() {

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