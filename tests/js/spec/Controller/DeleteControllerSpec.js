describe("In Delete Controller", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.DeleteController, "init");
		Notes.DeleteController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
