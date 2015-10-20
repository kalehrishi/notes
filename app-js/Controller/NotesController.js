/*
 * @name Notes.notesController
*/
Notes.NotesController = {
	/*
	 * @property {null}
	*/
    notesView: null,
    /*
     * @desc Function init() calls to Notesview of show function
     * @param {null}
    */
    init: function () {
        console.log("In notesController");
        
        Notes.utils.get("/notes", true, function (response) {
                console.log("OnSuccess Response:", response);
                this.notesView = new Notes.NotesView();
                this.notesView.create(response);
                
                this.notesView.setLogoutClickedHandler(function(e, self){
                    console.log("call to LogoutController");
                    Notes.LogoutController.init();
                });
                
                this.notesView.setCreateNoteClickedHandler(function(e, self){
                    console.log("call to CreateNoteController");
                    Notes.CreateNoteController.init();
                });

                this.notesView.setTitleClickedHandler(response,function(e, self, noteId) {
                    console.log("call to View NoteController");
                    Notes.NoteController.init(noteId);
                });
                
                this.notesView.setDeleteClickedHandler(response, function (e, self, noteId) {
                    console.log("call to Delete Controller");
                    Notes.DeleteController.init(noteId);
                });

            },
            function (response) {
                console.log("OnFailure Response:", response);
                this.notesView = new Notes.NotesView(response);
            });
    }
};
