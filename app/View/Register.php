<?php
$data = json_decode($response, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registation Form</title>
  <style>
 .error { 
  }
</style>
</head>
<body>
    <form  method="POST">
    <fieldset>
    <legend>Registration Form:</legend>
    <table>
      <tr>
        <td>FirstName:</td>
        <td><input type="text" name="firstName"></input></td> 
      </tr>
      <tr>
        <td>LastName:</td>
        <td><input type="text" name="lastName"></input></td> 
      </tr>
      <tr>
        <td>Email:</td>
        <td><input type="text" name="email"></input></td> 
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="password"></input></td> 
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
        <td><input type="submit" value="Submit" /></td>
        <td><input type="reset"  value="Reset" /></td>
      </tr>
    </table>
    </fieldset>
  </form>
</body>
</html>
