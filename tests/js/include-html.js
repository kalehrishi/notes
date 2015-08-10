$(function () {

  var setupLoginHTML =  "<div id='container'><input type='email' id='email' required />" +
                  "<input type='password' id='password' required='required'/>" +                        
                  "<input type='hidden' id='id'/>" +
                  "<input type='hidden' id='firstName'/>" +
                  "<input type='hidden' id='lastName'/>"   +                      
                  "<input type='hidden' id='createdOn' />" +                             
                  "<input type='hidden' id='userModel' />" + 
                  "<div id='errorMessage'></div>"          + 
                  "<input type='submit' value='Login' id='login'/>"  + 
                  "<input type='reset'  value='Reset' id='reset'/>"  +   
                  "<div id='errorMessage'></div>"           +
                  "</div>";
  document.body.innerHTML = setupLoginHTML;
});
