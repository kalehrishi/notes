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

<script type="text/javascript" src="../../lib/jquery/dist/jquery.min.js"></script>

<script type="text/javascript" src="../../lib/main-min.js"></script>

</head>

<body>
<div id="container">

    <table>
      <tr>
        <td>Email:</td>
        <td><input type="email" id="email" required/></td>
      </tr>
      <tr> 
        <td>Password:</td>
        <td><input type="password" id="password" required="required"/></td> 
      </tr>
      <tr><td>
      <input type="hidden" id="id"/>
      <input type="hidden" id="firstName"/>
      <input type="hidden" id="lastName"/></td>
      </tr>
      <tr>
        <td><input type="hidden" id="createdOn" /></td>
        <td><input type="hidden" id="userModel" /></td>
      </tr>
      <tr><?php
        if (is_string($data['data'])) {
            ?>
            <td>Error :-  </td>
            <td><p class="error" ><?php echo $data['data'];
        }?></p></td>
       </tr>
      <tr>
        <td><input type="submit" value="Login" id="login"/></td>
        <td><input type="reset"  value="Reset" id="reset"/></td>
      </tr>
      </table>
    </div>
    <div id="errorMessage"></div>
</body>
</html>
