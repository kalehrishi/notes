describe("In Notes View", function() {
	var spy, notesView;
	beforeEach(function() {
		notesView = new Notes.NotesView();
	});

	it("A function init called", function() {
		spy = spyOn(notesView, "show");
		notesView.show();
		expect(spy).toHaveBeenCalled();
	});
});
