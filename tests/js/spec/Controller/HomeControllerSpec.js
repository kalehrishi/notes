describe("In HomeController", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.HomeController, "init");
		Notes.HomeController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
