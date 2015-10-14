describe("In LoginController", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.LoginController, "init");
		Notes.LoginController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
