<!DOCTYPE html>
<html>
<body>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="tags[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
<style type="text/css">

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

}
</style>
</head>
<form method="post">
<div id="comment_form" class="container">
<div>Create Note :</div>
  <div>
    <input type="text" name="title" id="title" placeholder="Title">
  </div>
  <div>
    <textarea rows="10" name="body" id="body" placeholder="Description"></textarea>
  </div><div class="input_fields_wrap">
    <button class="add_field_button">Add More Tags</button>
    <div><input type="text" name="tags[]"></div>
</div>
<div>
    <input type="submit" value="Save">
  </div>
</div>
</form> 
</body>
</html>
