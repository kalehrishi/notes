function NotesController() {
}
NotesController.prototype.init = function() {
	console.log("in init");
}

$(function() {
    var notesController = new NotesController();
    notesController.init();
})