describe("In NotesView tests", function() {

	it ("should invoke the btnCreate click event.", function() {
	    spyEvent = spyOnEvent('#create', 'click');
	    $('#create').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#create');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

  	it ("should invoke the btnLogout click event.", function() {
	    spyEvent = spyOnEvent('#logout', 'click');
	    $('#logout').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#logout');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

  	it ("should invoke the btnTitle click event.", function() {
	    spyEvent = spyOnEvent('#title', 'click');
	    $('#title').trigger( "click" );
	       
	    expect('click').toHaveBeenTriggeredOn('#title');
	    expect(spyEvent).toHaveBeenTriggered();
  	});

	it("A function setLogoutNoteClickHandler have been called", function(done) {
		var notesView, dummyHandler = jasmine.createSpy();
		notesView = new Notes.NotesView();

		var spy = spyOn(notesView, "setLogoutClickedHandler");
		notesView.setLogoutClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});


	it("A function setCreateNoteClickHandler have been called", function(done) {
		var notesView, dummyHandler = jasmine.createSpy();
		notesView = new Notes.NotesView();

		var spy = spyOn(notesView, "setCreateNoteClickedHandler");
		notesView.setCreateNoteClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});

	it("A function setTitleClickedHandler have been called", function(done) {
		var notesView, dummyHandler = jasmine.createSpy();
		notesView = new Notes.NotesView();

		var spy = spyOn(notesView, "setTitleClickedHandler");
		notesView.setTitleClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});

	it("A function setDeleteClickedHandler have been called", function(done) {
		var notesView, dummyHandler = jasmine.createSpy();
		notesView = new Notes.NotesView();

		var spy = spyOn(notesView, "setDeleteClickedHandler");
		notesView.setDeleteClickedHandler(dummyHandler);

		expect(spy).toHaveBeenCalled();
		done();
	});
});