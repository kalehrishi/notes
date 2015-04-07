<?php
$data = json_decode($response, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
  .logoutLblPos{

   position:fixed;
   right:100px;
   top:5px;
}
 .error { 
  }
</style>
</head>
<body>
    <form  method="POST">
    <table>
      <tr>
        <td>Title:</td>
        <td><input type="text" name="title"></input></td> 
      </tr>
      <tr>
        <td>Body:</td>
        <td><input type="text" name="body"></input></td> 
      </tr>
      <tr>
      </tr>
      <tr>
        <?php
        if (is_string($data['data'])) {
            ?>
            <td>Error :-  </td>
            <td><div class="error" ><?php
            echo $data['data'];?>
            </div></td>
        <?php
        }
        ?>
      </tr>
      <tr>
      <td><input type="submit" name='button' value="Submit" /></td>
      <td><input type="reset"  value="Reset" /></td>
      </tr>
      <tr>
      <label class="logoutLblPos">
      <input  type="submit"  name="button" value="Logout">
      </label>
      </tr>
    </table>

  </form>
</body>
</html>



