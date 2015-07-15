var notesController = {
    notesView: null,
    init: function () {
        this.notesView = new Notes.NotesView();
        this.notesView.show();
    }
};
