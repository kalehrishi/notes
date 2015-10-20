describe("Create Note View tests", function() {

	it ("should invoke the btnBack click event.", function() {
	    spyEvent = spyOnEvent('#back', 'click');
	    $('#back').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#back');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

	it("A function setBackClickHandler have been called", function(done) {
		var noteView, dummyHandler = jasmine.createSpy();
		noteView = new Notes.NoteView();

		var spy = spyOn(noteView, "setBackButtonClickedHandler");
		noteView.setBackButtonClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});
});