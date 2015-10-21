describe("In Notes Controller", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.NotesController, "init");
		Notes.NotesController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
