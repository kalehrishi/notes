function NoteModel (title, description) {
	this.title = title;
	this.description = description;

	this.getTitle = function() {
		return this.title;
	};

	this.getDescription = function() {
		return this.description;
	};
}

NoteModel.prototype.saveBtnOnclick = function() {
	var saveBtnId = document.getElementById('save');
	
	saveBtnId.addEventListener("click", function() {
	var title = document.getElementById('title').value;
	console.log(title);
		
	var description = document.getElementById('description').value;
	console.log(description);
	
	var noteTags = [];
	
	var noteModel = new NoteModel(title, description);
	console.log(noteModel.getTitle());
	console.log(noteModel.getDescription());

	NoteModel.prototype.createNoteModel(noteModel.getTitle(), noteModel.getDescription(), noteTags);
	
	});
};
NoteModel.prototype.createNoteModel = function(title, description, noteTags) {
	var noteModel = {
        "title": title,
        "body": description,
        "noteTags": noteTags
    };
    console.log(noteModel);
    new NoteModelView(noteModel);
};
