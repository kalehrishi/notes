describe("Note Tags View tests", function() {

	it ("should invoke the btnDelete click event.", function() {

		for (var i = 0; i< 3; i++) {
			var id, anchorEleRef;
			id = "del_"+i;
       		anchorEleRef = document.getElementsByTagName("a")[i];
       		anchorEleRef.setAttribute("id", id);

       		spyEvent = spyOnEvent(anchorEleRef, 'click');
	    	$(anchorEleRef).trigger( "click" );
	       
	    	expect('click').toHaveBeenTriggeredOn(anchorEleRef);
	    	expect(spyEvent).toHaveBeenTriggered();
	    }	
  	});
});