describe("Test XHR", function() {
	
	beforeEach(function() {
		jasmine.Ajax.install();
	});

	afterEach(function() {
		jasmine.Ajax.uninstall();
	});

	it("specifying response when you need it", function() {
    var doneFn, successOutput, xhr;

    successOutput = {"status":1,"message":"SUCCESS","version":"1.0.0","data":[],"debugData":null};
    doneFn = jasmine.createSpy("success");
		
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == this.DONE) {
        console.log(this.responseText);
        doneFn(this.responseText);
      }
    };

    xhr.open("POST", "/api/session");
    xhr.send();

    expect(jasmine.Ajax.requests.mostRecent().method).toEqual("POST");
    expect(jasmine.Ajax.requests.mostRecent().url).toBe("/api/session");
    expect(doneFn).not.toHaveBeenCalled();

    jasmine.Ajax.requests.mostRecent().respondWith({
      "status": 200,
      "contentType": "text/plain",
      "responseText": {"status":1,"message":"SUCCESS","version":"1.0.0","data":[],"debugData":null}
    });

    expect(doneFn).toHaveBeenCalledWith(successOutput);
  });
});
