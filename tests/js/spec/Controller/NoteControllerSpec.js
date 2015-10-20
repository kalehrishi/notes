describe("In Note Controller", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.NoteController, "init");
		Notes.NoteController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
