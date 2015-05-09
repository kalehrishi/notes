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
                var tags = new Array();
                var ids = new Array();
                for (var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {
                    tags.push(JSONObject[key]["tag"]);
                    ids.push(JSONObject[key]["id"]);
                    }
                }
                console.log(obj1.userTags[0].tag);
                window.count = 0;
    $("a[id^='add']").live("click", null, function (e) {
        window.count++;
        var txtTagsID= "txtTags" + window.count;
        var btnAddID = "add" + window.count;
        var btnDelID = "del" + window.count;
        var div1 = $("#divTest");
        console.log(e);
        var div2 = $("<div class='div-style'></div>")
            .append($("<input type='hidden' id='" + txtTagsID+ "' name='userTag[]' value='"+obj1.userTags+"' />"
                + "<input id='" + txtTagsID+ "' name='tag[]' />"
                + "  <a href='#' id='" + btnDelID + "' >Del</a>"));
        div2.appendTo(div1);
    });

    $("a[id^='del']").live("click", null, function () {
        var li = $(this).parent();
        li.remove();
        window.count--;
    });
    
    $("input:text[id^='txtTags']").live("focus.autocomplete", null, function () {
        $(this).autocomplete({
            source: tags,
            minLength: 0,
            delay: 0
        });

        $(this).autocomplete("search");
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

/*.container{
  font-family: 'Lucida Grande', 'Helvetica Neue', sans-serif;
  font-size: 13px;
}

#comment_form input, #comment_form textarea {
  border: 4px solid rgba(0,0,0,0.1);
  padding: 8px 10px;
  font-weight: bold;
  
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  
  outline: 0;
}

#comment_form textarea {
  width: 150px;
  height: 100px;
}

#comment_form input[type="submit"] {
  cursor: pointer;
  background: -webkit-linear-gradient(top, #efefef, #ddd);
  background: -moz-linear-gradient(top, #efefef, #ddd);
  background: -ms-linear-gradient(top, #efefef, #ddd);
  background: -o-linear-gradient(top, #efefef, #ddd);
  background: linear-gradient(top, #efefef, #ddd);
  color: #333;
  text-shadow: 0px 1px 1px rgba(255,255,255,1);
  border: 1px solid #ccc;
}

#comment_form input[type="submit"]:hover {
  background: -webkit-linear-gradient(top, #eee, #ccc);
  background: -moz-linear-gradient(top, #eee, #ccc);
  background: -ms-linear-gradient(top, #eee, #ccc);
  background: -o-linear-gradient(top, #eee, #ccc);
  background: linear-gradient(top, #eee, #ccc);
  border: 1px solid #bbb;
}

#comment_form input[type="submit"]:active {
  background: -webkit-linear-gradient(top, #ddd, #aaa);
  background: -moz-linear-gradient(top, #ddd, #aaa);
  background: -ms-linear-gradient(top, #ddd, #aaa);
  background: -o-linear-gradient(top, #ddd, #aaa);
  background: linear-gradient(top, #ddd, #aaa); 
  border: 1px solid #999;
}

#comment_form div {
  margin-bottom: 8px;
  margin: 10px;
}
.container {
  width: 300px;
  border: 1px solid black;

}*/

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
    <div><input type="submit" value="Save"></div>
    
</div>
</form>
</body>
<html>