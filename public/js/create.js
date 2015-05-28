var UserTagModel = function() {};

var UserTagView = function() {};

var NoteTagView = function() {};

var DeleteLinkView = function() {};

var UserTagController = function() {};

var NoteTagController = function() {};

function passUserTagsAndCreateNoteTags(userTagsArray) {
    var userId = getUserId();
    console.log(userId);

    var noteTags = [];
    for (var i = 0; i < userTagsArray.length; i++) {
        var userTag = userTagsArray[i];
        userTag.userId = userId;
        noteTags[i] = {
            "id": noteTagId,
            "noteId": noteId,
            "userTagId": userTagId,
            "isDeleted": isDeleted,
            "userTag": userTag
        };
    }
    console.log(noteTags);

    passNoteTagsAndCreateNoteModel(noteTags);
}

function passNoteTagsAndCreateNoteModel(noteTags) {
    var title = document.getElementById("title").value;
    var body = document.getElementById("body").value;

    var noteTagId = document.getElementById("noteTagId").value;
    var noteId = document.getElementById("noteId").value;
    var userTagId = document.getElementById("userTagId").value;
    var isDeleted = document.getElementById("isDeleted").value;

    var json = {
        "title": title,
        "body": body,
        "noteTags": noteTags
    };
    document.getElementById("noteModel").value = JSON.stringify(json);
}

function getUserId() {
    var allcookies = document.cookie;
    console.log(allcookies);

    // Get all the cookies pairs in an array
    cookiearray = allcookies.split(';');
    console.log(cookiearray);

    // Now take key value pair out of this array
    for (var i = 0; i < cookiearray.length; i++) {
        name = cookiearray[i].split('=')[0].trim();
        value = cookiearray[i].split('=')[1].trim();
        if (name == "userId")
            return value;
    }
}
NoteTagView.addTag = function(txtIdValue) {
    if ((txtIdValue).length == 0) {
        alert("The textbox should not be empty");
        return;
    };

    var userTag = {
        "id": null,
        "userId": "null",
        "tag": txtIdValue,
        "isDeleted": "0"
    };

    NoteTagView.prototype.createNoteTags(userTag);

    document.getElementById("txtTags").value = "";
}

DeleteLinkView.prototype.createDeleteLink = function(userTag) {
    var x = document.createElement("A");
    var t = document.createTextNode("Delete");

    x.setAttribute("href", "#");
    x.setAttribute("id", "del");
    x.setAttribute("value", JSON.stringify(userTag));
    x.appendChild(t);
    return x;
};
var userTagsArray = [];
NoteTagView.prototype.createNoteTags = function(userTag) {
    var noteTags = document.getElementById('note-tags');
    var liClickTag = document.createElement("LI");

    var div = document.createElement("span");
    div.appendChild(document.createTextNode(userTag.tag));

    liClickTag.appendChild(div);

    liClickTag.userTag = userTag;

    var appendDelete = DeleteLinkView.prototype.createDeleteLink(userTag);

    liClickTag.appendChild(appendDelete);
    noteTags.appendChild(liClickTag);

    userTagsArray.push(liClickTag.userTag);

    $("a[id^='del']").live("click", null, function(e) {
        var li = $(this).parent();
        var tag = li[0].childNodes[0].innerText;

        console.log(tag);
        console.log(userTagsArray);
        for (var i = 0; i < userTagsArray.length; i++) {
            if (tag == userTagsArray[i].tag)
                userTagsArray.splice(i, 1);
            passUserTagsAndCreateNoteTags(userTagsArray);
        }
        li.remove();
    });
    passUserTagsAndCreateNoteTags(userTagsArray);
};

UserTagView.prototype.setTags = function(userTagsFromServer) {
    var userTags = document.getElementById('user-tags');
    for (var i = 0; i < userTagsFromServer.length; i++) {
        //create and append tag to tag list

        var li = document.createElement("LI");

        li.setAttribute("class", "inputTags");
        li.appendChild(document.createTextNode(userTagsFromServer[i].tag));
        li.userTagsFromServer = userTagsFromServer[i];

        li.addEventListener("click", function() {
            console.log(this.userTagsFromServer);
            var userTag = this.userTagsFromServer;

            NoteTagView.prototype.createNoteTags(userTag);

        }, false);
        userTags.appendChild(li);
    }
};

UserTagModel.search = function() {
    $.ajax({
        type: 'GET',
        url: '/notes/api/userTag',
        data: 'id=testdata',
        datatype: "JSON",
        cache: false,

        success: function(result) {
            console.log(result);
            var userTagsFromServer = JSON.parse(result);

            UserTagView.prototype.setTags(userTagsFromServer);

        },
        error: function(result) {
            var errorMsg = JSON.parse(result);
            alert("Message: " + errorMsg);
        }
    });
};
NoteTagController.prototype.loadView = function(txtIdValue) {
    var noteTagView = NoteTagView.addTag(txtIdValue);
    console.log(noteTagView);

};
UserTagController.prototype.loadModel = function() {
    var userTagModel = UserTagModel.search();
    console.log(userTagModel);

};
$(document).ready(function() {

    var userTagController = new UserTagController;
    userTagController.loadModel();

    var noteTagController = new NoteTagController;
    
    var addBtnClk = document.getElementById("addBtnClk");
    addBtnClk.addEventListener('click', function() {
        var txtIdValue = document.getElementById("txtTags").value;
        noteTagController.loadView(txtIdValue)
    });

});