describe("In LoginController", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.loginController, "init");
		Notes.loginController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
