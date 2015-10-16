/*
 * @name Notes.NotesView
*/
Notes.NotesView = function (response, logoutClickedHandler, createClickedHandler, titleClickedHandler) {
	
    var notesViewTemplate = $("#hiddenNotesView").html();
    console.log("notesViewTemplate========",notesViewTemplate);
    var data, notesData = response.data;
    console.log("notesCollection====",notesData);
    data = { notesCollection: notesData };
    console.log("data====",data);
    
    if(data.notesCollection.length === 0) {
        console.log("In if");
        data = { newNote: "Note Not Create Yet!!! Create A note" };
        console.log("data========",data);
        notesViewTemplate = $("#hiddenNoNotesView").html();
    }

    Notes.View.show(notesViewTemplate, data);

    this.setLogoutClickedHandler = function (handler) {
    	console.log("In logout Clicked Handler");
    	
    	(function(self){
        var logoutElement = document.getElementById("logout");
    	console.log(logoutElement);
        
        if (logoutElement) {
            logoutElement.addEventListener("click", function (e) {
            	console.log(e);
                handler(e, self);
            }, false);
        }
    })(this);
	};

    this.setCreateNoteClickedHandler = function (handler) {
        console.log("In CreateNote Clicked Handler");
        
        (function(self){
        var crateNoteElement = document.getElementById("create");
        console.log(crateNoteElement);
        
        if (crateNoteElement) {
            crateNoteElement.addEventListener("click", function (e) {
                console.log(e);
                handler(e, self);
            }, false);
        }
    })(this);
    };

    this.setTitleClickedHandler = function (handler) {
        console.log("In Title Clicked Handler");
        (function(self){
            if(notesData.length > 0) {
                for (var i = 0; i< data.notesCollection.length; i++) {
            console.log("data.notesCollection[i]======",data.notesCollection[i]);
            var id = "note_title_"+data.notesCollection[i].id;
            console.log("Id======",id);

            var titleElement = document.getElementById(id);            
            if (titleElement) {
                titleElement.addEventListener("click", function (e) {
                    console.log("e.target======",e.target);
                    var noteId = e.target.getAttribute("value");
                    handler(e, self,noteId);
                }, false);
            }
        }
    }
        
    })(this);
    };

    this.setLogoutClickedHandler(logoutClickedHandler);
    this.setCreateNoteClickedHandler(createClickedHandler);
    this.setTitleClickedHandler(titleClickedHandler);
};