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
                var obj = '{ "userTags" :'  + result +  '}';
                console.log(obj);
                obj1 = JSON.parse(obj);
                var JSONObject =obj1.userTags;
                console.log(JSONObject.length);
                var tags = new Array();
                var ids = new Array();
                for (var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {
                    tags.push(JSONObject[key]["tag"]);
                    }
                }
                console.log(tags);
                console.log(obj1.userTags[0].tag);
                window.count = 0;
    $("a[id^='add']").live("click", null, function (e) {
        window.count++;
        var txtTagsID= "txtTags" + window.count;
        var btnAddID = "add" + window.count;
        var btnDelID = "del" + window.count;
        var div1 = $("#divTest");
       
        
        var div2 = $("<div class='div-style'></div>")
            .append($("<input id='"+txtTagsID+"' name='tag[]'/>"
                +"  <a href='#' id='" + btnDelID + "' >Del</a>"));
        div2.appendTo(div1);
       
    });
    
    $("a[id^='del']").live("click", null, function () {
        var li = $(this).parent();
        li.remove();
        window.count--;
    });
    
    $("input:text[id^='txtTags']").live("click", null, function (e) {
         
        $(this).autocomplete({
            source: tags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
        var idValue = e.target.attributes.id.value;
        console.log(idValue);
        var tag1 = document.getElementById(idValue).value;
        console.log(tag1);
        
        for(var i=0; i<JSONObject.length;i++)
        {
            var userTagID = "userTagId" + i;
            
            if(JSONObject[i].tag == tag1)
            {
                var tagObj = JSONObject[i];
                var str = JSON.stringify(tagObj);
                console.log(str);
                var div1 = $("#divTest1");
                var div2 = $("<div class='div-style1'></div>")
            .append($("<input type='hidden' id='"+userTagID+"' name='userTag[]' value='"+str+"'/>"));
        div2.appendTo(div1);
               }
        }
    });

    }

 });
    
});
</script>
<style type="text/css">
    .ul-style{
    max-height:80px; 
    width:350px; 
    overflow-x:hidden; 
    overflow-y:auto
}
.li-style{
    font-size:medium;
}
button{
    width:50px;
    margin-left:5px;
}
input{
    width:100px;
}

.ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
    }
    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    * html .ui-autocomplete {
        height: 100px;
    }
</style>
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
        <div class="div-style">
            <a href="#" id="add0">Add Tags</a>
        </div>

    </div>
    <div id="divTest1">
        <div class="div-style1">
        </div>

    </div>
    

    <div><input type="submit" value="Save"></div>
    
</div>
</form>

</body>
<html>