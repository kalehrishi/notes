describe("In Create Note Controller", function() {
	var spy;
	it("call to init function", function() {
		spy = spyOn(Notes.CreateNoteController, "init");
		Notes.CreateNoteController.init();
		
		expect(spy).toHaveBeenCalledWith();
	});
});
