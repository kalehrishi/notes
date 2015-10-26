Notes.CreateNoteView = function () {
	
	this.create = function () {
		
        var template = $("#hiddenCreateNoteView").html();
        var data = {};
        Notes.View.show(template, data);

        $("#userTags").show();
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

    this.readUserData = function (userTagsArray) {
        var userId, title, body, noteTagId, noteId, userTagId, isDeleted, noteTags = [];

        title = document.getElementById("title").value;
        body = document.getElementById("body").value;
        
        userId = this.getUserId();

        for (var i = 0; i < userTagsArray.length; i++) {
            var userTag = userTagsArray[i];
            userTag.userId = userId;
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
    
    this.getUserId = function () {
        var name, value, cookiearray, allcookies = document.cookie;
        console.log(allcookies);

        // Get all the cookies pairs in an array
        cookiearray = allcookies.split(";");
        console.log(cookiearray);

        // Now take key value pair out of this array
        for (var i = 0; i < cookiearray.length; i++) {
            name = cookiearray[i].split("=")[0].trim();
            value = cookiearray[i].split("=")[1].trim();
            if (name == "userId") {
                return value;
            }
        }
    };
};
