<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
 .error { 
  }
  .fieldset {
  padding:10px;
  width:250px;
  line-height:1.8;
}
.title {
  font-weight: bold;
}
</style>
</head>
<body>
    <fieldset class = "fieldset">
    <legend>Note</legend>
    <table class="tbl">
    <?php
    if (is_string($response)) {
        ?>
    <tr>
        <td>Error :-  </td>
            <td><div class="error" >
            <?php echo $response; ?>
            </div></td>
         
      </tr>
        <?php
    } else {
        ?>
      <tr>
        <td class="title"><?php echo $response['title']; ?></td> 
      </tr>
      <tr>
        <td><?php echo $response['body']; ?></td> 
      </tr>
      <tr>
        <td>Tags: <?php
        if (empty($response['noteTags'])) {
            echo "No Tags";
        } else {
            echo $response['noteTags'];
        }

        ?></td>
      </tr>
      <tr><td><button type="button">Edit</button></td>
        <?php
    }
        ?>
      <td><a href="/notes"><button type="button">Back</button></a></td></tr>

    </table>
    </fieldset>
</body>
</html>
