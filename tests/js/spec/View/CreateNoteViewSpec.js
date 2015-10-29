describe("Create Note View tests", function() {

	it ("should invoke the btnBack click event.", function() {
	    spyEvent = spyOnEvent('#back', 'click');
	    $('#back').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#back');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

  	it ("should invoke the btnSave click event.", function() {
	    spyEvent = spyOnEvent('#save', 'click');
	    $('#save').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#save');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

  	it ("should invoke the btnAdd click event.", function() {
	    spyEvent = spyOnEvent('#addBtn', 'click');
	    $('#addBtn').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#addBtn');
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

	it("A function setSaveButtonClickedHandler have been called", function(done) {
		var createNoteView, dummyHandler = jasmine.createSpy();
		createNoteView = new Notes.CreateNoteView();

		var spy = spyOn(createNoteView, "setSaveButtonClickedHandler");
		createNoteView.setSaveButtonClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});

	it("A function setAddButtonClickedHandler have been called", function(done) {
		var createNoteView, dummyHandler = jasmine.createSpy();
		createNoteView = new Notes.CreateNoteView();

		var spy = spyOn(createNoteView, "setAddButtonClickedHandler");
		createNoteView.setAddButtonClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});
});