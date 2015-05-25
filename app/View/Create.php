<!DOCTYPE html>
<html>

<body>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
        </script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.19/themes/cupertino/jquery-ui.css">

        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
        <script>
            $(document).ready(function() {
                $.ajax({

                    type: 'GET',
                    url: '/notes/api/userTag',
                    data: 'id=testdata',
                    datatype: "JSON",
                    cache: false,

                    success: function(result) {
                        console.log(result);

                        var userTagsFromServer = JSON.parse(result);
                        console.log(userTagsFromServer);

                        setTags(userTagsFromServer);
                    },
                    error: function(result) {
                        var errorMsg = JSON.parse(result);
                        alert("Message: " + errorMsg);
                    }
                });
            });

            function addTag() {
                if ((document.getElementById("txtTags").value).length == 0) {
                    alert("The textbox should not be empty");
                    return;
                }
                var txtTagsIdValue = document.getElementById("txtTags").value;
                var userTag = {
                    "id": null,
                    "userId": "null",
                    "tag": txtTagsIdValue,
                    "isDeleted": "0"
                };
                createNoteTagsList(userTag);
                document.getElementById("txtTags").value = "";
            }
            var userTagsArray = [];

            function setTags(userTagsFromServer) {
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

                        createNoteTagsList(userTag);

                    }, false);
                    userTags.appendChild(li);
                }
            }

            function createNoteTagsList(userTag) {
                var noteTags = document.getElementById('note-tags');
                var liClickTag = document.createElement("LI");

                var div = document.createElement("span");
                div.appendChild(document.createTextNode(userTag.tag));

                liClickTag.appendChild(div);

                liClickTag.userTag = userTag;

                var appendDelete = appendDeleteLink(userTag);

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

            }

            function appendDeleteLink(userTag) {
                var x = document.createElement("A");
                var t = document.createTextNode("Delete");

                x.setAttribute("href", "#");
                x.setAttribute("id", "del");
                x.setAttribute("value", JSON.stringify(userTag));
                x.appendChild(t);
                return x;
            }

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
        </script>
    </head>

    <body>
        <form method="post">
            <div id="comment_form" class="container">
                <div>Create Note :</div>

                <div>
                    <input type="text" id="title" placeholder="Title" required="">
                </div>
                <div>
                    <textarea rows="10" id="body" placeholder="Description"></textarea>
                </div>

                <div id="divTest">
                    <ul id="user-tags">
                        <input type="text" id="txtTags" />
                        <span><button type="button" onclick="addTag()">Add</button></span>
                    </ul>
                </div>
                <div id="note-tags">
                    <input type="hidden" id="noteTagId" />
                    <input type="hidden" id="noteId" />
                    <input type="hidden" id="userTagId" />
                    <input type="hidden" id="isDeleted" />
                    <input type="hidden" id="noteModel" name="noteModel" />
                </div>
                <input type="submit" value="Save">
                <a href="/notes">
                    <button type="button">Back</button>
                </a>
            </div>
        </form>
    </body>
</html>
