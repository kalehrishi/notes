describe("In Logout Controller", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.LogoutController, "init");
		Notes.LogoutController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
