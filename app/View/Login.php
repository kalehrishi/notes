<?php
$data = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
 .error { 
  }
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
        </script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        
        <script type="text/javascript" src="../js/Controller/LoginController.js"></script>
</head>
<body>
    <table>
      <tr>
        <td>Email:</td>
        <td><input type="text" id="email"/></td>
      </tr>
      <tr> 
        <td>Password:</td>
        <td><input type="password" id="password"/></td> 
      </tr>
      <input type="hidden" id="id">
      <input type="hidden" id="firstName">
      <input type="hidden" id="lastName">
      <input type="hidden" id="createdOn">
      <input type="hidden" id="userModel">
      <tr>
        <script language="php">
        if (is_string($data['data'])) {
            </script>
            <td>Error :-  </td>
            <td><div class="error" ><script language="php">echo $data['data'];
        }
        </script></div></td>
       </tr>
      <tr>
        <td><input type="submit" value="Login" id="login"/></td>
        <td><input type="reset"  value="Reset" id="reset"/></td>
      </tr>
    </table>
</body>
</html>
