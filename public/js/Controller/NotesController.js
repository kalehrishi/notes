var notesController = {
    notesView: null,
    init: function () {
        this.notesView = new NotesView();
        this.notesView.show();
    }
};