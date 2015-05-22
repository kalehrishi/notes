<!DOCTYPE html>
<html>
<body>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
</script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css"
href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.19/themes/cupertino/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="../CSS/style.css">
<script>
$(document).ready( function() {
    
    $.ajax({
        
        type: 'GET',
        url: '/notes/searchtag',
        data: 'id=testdata',
        datatype: 'json',
        cache: false,

        success: function(result) {
            console.log(result);
            
            var userTagsFromServer = JSON.parse(result);
            console.log(userTagsFromServer);
            
            var userTags=document.getElementById('user-tags');
            var userTagsArray = [];
            
            for(var i=0;i<userTagsFromServer.length;i++){
            //create and append tag to tag list

            var li=document.createElement("LI");
            
            li.setAttribute("class", "inputTags");
            li.appendChild(document.createTextNode(userTagsFromServer[i].tag));
            li.userTagsFromServer=userTagsFromServer[i];

            li.addEventListener("click",function(){
                
            var noteTags=document.getElementById('note-tags');
            var liClickTag=document.createElement("LI");
            
            var div=document.createElement("span");
            div.appendChild(document.createTextNode(this.userTagsFromServer.tag));
            
            liClickTag.appendChild(div);

            liClickTag.userTagsFromServer= this.userTagsFromServer;
            
            var x = document.createElement("A");
            var t = document.createTextNode("Delete");
            
            x.setAttribute("href", "#");
            x.setAttribute("id", "del");
            x.setAttribute("value", JSON.stringify(this.userTagsFromServer));
            x.appendChild(t);

            liClickTag.appendChild(x);
            noteTags.appendChild(liClickTag);
            
            userTagsArray.push(liClickTag.userTagsFromServer);
            console.log(userTagsArray);

            passArrayOfObjectsAndSetTagValues(userTagsArray);

        },false);
userTags.appendChild(li);
}

$("button[id^='addTags']").live("click", null, function (e) {
    if((document.getElementById("txtTags").value).length == 0) {
        alert("The textbox should not be empty");
        return;
    }
    
    var txtTagsIdValue = document.getElementById("txtTags").value;
    var userTag = {"id":null, "userId":"null", "tag": txtTagsIdValue, "isDeleted":"0"};

    var noteTags=document.getElementById('note-tags');
    var li = document.createElement("LI");
    var div=document.createElement("span");
    
    div.appendChild(document.createTextNode(userTag.tag));
    li.appendChild(div);
            
    var x = document.createElement("A");
    var t = document.createTextNode("Delete");
    
    x.setAttribute("href", "#");
    x.setAttribute("id", "del");
    x.appendChild(t);
    
    li.appendChild(x);
                   
    noteTags.appendChild(li);
            
    userTagsArray.push(userTag);
    console.log(userTagsArray);

    passArrayOfObjectsAndSetTagValues(userTagsArray);
    document.getElementById("txtTags").value = "";
});

$("a[id^='del']").live("click", null, function (e) {
    var li = $(this).parent();
    var tag  = li[0].childNodes[0].innerText;

    console.log(tag);

    for(var i=0;i < userTagsArray.length;i++)
    {
        if(tag == userTagsArray[i].tag)
            userTagsArray.splice(i,1);
        passArrayOfObjectsAndSetTagValues(userTagsArray);
    }
   li.remove();
});
}
});
});
function passArrayOfObjectsAndSetTagValues(userTagsArray){
    document.getElementById("Tags").value = JSON.stringify(userTagsArray);
}
</script>
</head>
<body>
<form method="post">
<div id="comment_form" class="container">
    <div>Create Note :</div>
    
    <div>
        <input type="hidden" name="id" />
        <input type="text" name="title" id="title" placeholder="Title" required="">
    </div>
    <div>
        <textarea rows="10" name="body" id="body" placeholder="Description"></textarea>
    </div>

    <div id="divTest">
        <ul id="user-tags">
        <input type="text" id="txtTags"/>
        <span><button type="button" id="addTags">Add</button></span>
        </ul>
    </div>
    <div id="note-tags">
    </div>
    <div>
    <input type="hidden" id="Tags" name="userTag"/>
    </div>
<input type="submit" value="Save">    
</div>
</form>    
</body>
</html>