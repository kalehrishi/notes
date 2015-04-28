<!DOCTYPE html>
<html>
<body>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
  $(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        
        $('#addScnt').live('click', function() {
                $('<p><label for="p_scnts"><input type="text" id="searchField" class="p_scnt" size="20" onkeyup="findTag(this.value)" name="tag" value="" autocomplete="off" placeholder="Enter Tag Name" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                i++;
                return false;
        });
        
        $('#remScnt').live('click', function() { 
                if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
});
});
</script>
<script type="text/javascript" src="../jquery.js"></script>
<!-- <script type="text/javascript" src="../jquery.autocomplete.js"></script>

 -->

<script>
function findTag(str){
  
  console.log("Hello..");
  
  if (str.length==0) { 
    document.getElementById("popups").innerHTML = "";
    //document.getElementById("livesearch").innerHTML="";
    //document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      console.log(xmlhttp.responseText);
      obj = JSON.parse(xmlhttp.responseText);
      var tempDiv = document.createElement("div");
        tempDiv.innerHTML = obj.tag;
        tempDiv.onclick = makeChoice;
        tempDiv.className = "suggestions";
        document.getElementById("popups").appendChild(tempDiv);
      //document.getElementById("livesearch").innerHTML=obj.tag;
      //document.getElementById("livesearch").style.border="1px solid #A5ACB2";

    }
  }
  xmlhttp.open("GET","../complete.php?q="+str,true);
  xmlhttp.send();


  /*$(".p_scnt").autocomplete("../complete.php", {
        selectFirst: true
  });*/
}
function makeChoice(evt) {
  var thisDiv = (evt) ? evt.target : window.event.srcElement;
  document.getElementById("searchField").className.value = thisDiv.innerHTML;
  //document.getElementsByClassName("p_scnt").value = thisDiv.innerHTML;
  document.getElementById("popups").innerHTML = "";
}
</script>
<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<form method="post">
<div id="comment_form" class="container">
<div>Create Note :</div>
  <div>
    <input type="hidden" name="id">
    <input type="text" name="title" id="title" placeholder="Title">
  </div>
  <div>
    <textarea rows="10" name="body" id="body" placeholder="Description"></textarea>
  </div>
  <?php 
  $noteTags = array();
  $userTag = array();
  ?>
    <input type="hidden" name="$noteTags['id']">
    <input type="hidden" name="$noteTags['noteId']">
    <input type="hidden" name="$noteTags['userTagId']">
    <input type="hidden" name="$noteTags['isDeleted']">

     
<a href="#" id="addScnt">Add Another Tag</a>

<div id="p_scents">
    <p>
        <label for="p_scnts"><input type="text" id="searchField" class="p_scnt" size="20" onkeyup="findTag(this.value)" name="tag" value="" autocomplete="off" placeholder="Enter Tag Name" />
        </label>
    </p>
    <div id="popups"></div>
</div>
<input type="submit" value="Save">
  </div>
</form> 
</body>
</html>
