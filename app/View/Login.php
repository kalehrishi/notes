<?php
  $data=json_decode($response,true);

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
        <td><input type="text" name="email"></input></td> 
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="password"></input></td> 
      </tr>
      <tr>
        <?php if(is_string($data['data'])){?>
        <td>Error :-  </td>
        <td><div class="error" ><?php echo $data['data'];?></div></td>
        <?php }?>
      </tr>
      <tr>
        <td><input type="submit" value="Login" /></td>
        <td><button>Cancel</button></td> 
      </tr>
    </table>
  </form>
</body>
</html>
