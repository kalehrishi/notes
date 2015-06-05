function NoteModelView (noteModel) {
	console.log(noteModel);
	document.getElementById("noteModel").value = JSON.stringify(noteModel);
}