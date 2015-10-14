/*
 * @name Notes.notesController
*/
Notes.notesController = {
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
        
        this.notesView = new Notes.NotesView();
        this.notesView.show();
        

        console.log("after show");
        this.notesView = new Notes.NotesView(function (e, self) {
            self.logout();
        });

    }
};
