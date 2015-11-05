Notes.CreateNoteView = function () {
	
	this.create = function () {
		
        var template = $("#hiddenCreateNoteView").html();
        var data = {};
        Notes.View.show(template, data);
	};

	this.setBackButtonClickedHandler = function (handler) {
    	console.log("In Back Button Clicked Handler");
    	(function(self){
            var backButtonElement = document.getElementById("back");
            if (backButtonElement) {
                backButtonElement.addEventListener("click", function (e) {

                    handler(e, self);
                }, false);
            }
        })(this);
    };
    
    this.setAddButtonClickedHandler = function (handler) {
        console.log("In Back Button Clicked Handler");
        var addButtonElement, enteredTagValue, userTag;
        (function(self){
            addButtonElement = document.getElementById("addBtn");
            if (addButtonElement) {
                addButtonElement.addEventListener("click", function (e) {
                    enteredTagValue = document.getElementById("enteredTagValue").value;

                    if(enteredTagValue.length === 0) {
                        alert("The textbox should not be empty");
                        return;
                    }
                    userTag = {
                        "id": "",
                        "userId": "",
                        "tag": enteredTagValue,
                        "isDeleted": "0"
                    };

                    handler(e, self, userTag);

                    //clear text value
                    document.getElementById("enteredTagValue").value = "";
                }, false);
            }
        })(this);
    };

    this.showError = function (response) {
        var errorMsg = response.data;
        document.getElementById("error").innerText = "Error: ";
        document.getElementById("errorMessage").innerText = errorMsg;
    };

    this.getInputValues = function (userSelectedTagsArray) {
        var noteTags = [], userId, title, body, noteTagId, noteId, userTagId, isDeleted;

        title = document.getElementById("title").value;
        body = document.getElementById("body").value;

        for (var i = 0; i < userSelectedTagsArray.length; i++) {
            var userTag = userSelectedTagsArray[i];
            
            noteTags[i] = {
                "id": document.getElementById("noteTagId").value,
                "noteId": document.getElementById("noteId").value,
                "userTagId": document.getElementById("userTagId").value,
                "isDeleted": document.getElementById("isDeleted").value,
                "userTag": userTag
            };
        }
        console.log("noteTags====",noteTags);
        
        return {
            title: title,
            body: body,
            noteTags: noteTags
        };
    };

    this.setSaveButtonClickedHandler = function (handler) {
        console.log("In Save Button ClickedHandler...");
        (function(self){
            var saveButton = document.getElementById("save");
            console.log("save Button==",saveButton);
            if(saveButton) {
                saveButton.addEventListener("click", function (e) {
                    handler(e, self);
                }, false);
            }
        })(this);
    };
};
