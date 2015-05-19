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
             var userTags=document.getElementById('user-tags');
             var userTagsArray = [];

            for(var i=0;i<userTagsFromServer.length;i++){
            //create and append tag to tag list 
            
            var tag=document.createElement("LI");
            tag.setAttribute("class", "inputTags");
            tag.appendChild(document.createTextNode(userTagsFromServer[i].tag));

            tag.userTagsFromServer=userTagsFromServer[i];
            
            
            tag.addEventListener("click",function(){
           
            var noteTags=document.getElementById('note-tags');
            console.log(noteTags);
            console.log(this.userTagsFromServer.tag);
            var tag=document.createElement("LI");
            tag.appendChild(document.createTextNode(this.userTagsFromServer.tag));
            tag.userTagsFromServer=JSON.stringify(this.userTagsFromServer);
            noteTags.appendChild(tag);
            console.log(tag.userTagsFromServer);
            userTagsArray.push(tag.userTagsFromServer);
            document.getElementById("Tags").value = userTagsArray ;
            console.log(userTagsArray);
        },false);
            userTags.appendChild(tag);
}
$("button[id^='addTags']").live("click", null, function (e) {
            if((document.getElementById("txtTags").value).length == 0) {
                alert("The textbox should not be empty");
                return;
            } 
            var userTag = document.getElementById("txtTags").value;
            console.log(userTag);
            
            var noteTags=document.getElementById('note-tags');
            console.log(noteTags);

            var tag = document.createElement("LI");
            
            tag.appendChild(document.createTextNode(userTag));
            
            //tag.userTag = JSON.stringify(userTag);
            
            noteTags.appendChild(tag);


          
            userTagsArray.push(userTag);
            document.getElementById("Tags").value = userTagsArray;
            console.log(userTagsArray);

            document.getElementById("txtTags").value = "";      
    });
}
});
});
   
</script>
</head>
<body>
<form method="post">
<div id="comment_form" class="container">
    <div>Create Note :</div>
    
    <div>
        <input type="hidden" name="id">
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
    <div id="note-tags"></div>
    <input type="hidden" id="Tags" name="userTag"/>
<input type="submit" value="Save">    
</div>
</form>    
</body>
</html>