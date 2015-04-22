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
.label {
  border: 1px solid black;
  background-color: yellow;
  border-radius: 3px;
  vertical-align: top;
  font-size: 10px;
  line-height: 1.8;
  zoom: 1;
  padding: 0 3px 0;
  white-space: normal;
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
        <td><?php
        if (empty($response['noteTags'])) {
            echo "No Tags";
        } else {
          for ($i=0; $i < count($response['noteTags']); $i++) { 
            
            ?>
            <span class="label"><?php echo $response['noteTags'][$i]['userTag']['tag'];?>
            </span>
            <?php
          }
        }
?></td>
      </tr>
      <tr><td><button type="button">Update</button>
        <?php
    }
        ?>
      <a href="/notes"><button type="button">Back</button></a></td></tr>

    </table>
    </fieldset>
</body>
</html>
