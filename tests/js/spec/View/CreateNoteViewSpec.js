describe("Create Note View tests", function() {

	it ("should invoke the btnBack click event.", function() {
	    spyEvent = spyOnEvent('#back', 'click');
	    $('#back').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#back');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

	it("A function setBackClickHandler have been called", function(done) {
		var createNoteView, dummyHandler = jasmine.createSpy();
		createNoteView = new Notes.CreateNoteView();

		var spy = spyOn(createNoteView, "setBackButtonClickedHandler");
		createNoteView.setBackButtonClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});
});