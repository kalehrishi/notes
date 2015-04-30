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
</head>
<body>
    <form  method="POST">
    <table>
      <tr>
        <td>Email:</td>
        <td><input type="text" name="email" /></td>
      </tr>
      <tr> 
        <td>Password:</td>
        <td><input type="password" name="password" /></td> 
      </tr>
      <tr>
        <script language="php">
        if (is_string($data['data'])) {
            </script>
            <td>Error :-  </td>
            <td><div class="error" >
            <script language="php">
            echo $data['data'];
        }
        </script></div></td>
       </tr>
      <tr>
        <td><input type="submit" value="Login" /></td>
        <td><input type="reset"  value="Reset" /></td>
      </tr>
    </table>
  </form>
</body>
</html>
