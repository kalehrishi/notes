<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
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
  margin-left: 3px; 
  padding: 3px 3px 3px;
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
      <td>Error :-</td>
      <td><div class="error" ><span><?php echo $response; ?></div></td>       
    </tr>
        <?php
    } else {
        ?>
    <tr>
      <td><div class="title"><?php echo $response->getTitle(); ?></div></td> 
    </tr>
    <tr>
      <td><div class="body"><?php echo $response->getBody(); ?></div></td> 
    </tr>
    <tr>
      <td><span><?php if ($response->getNoteTags()->getTotal() < 0) {
              echo "No Tags";
} else ?></span>
            <?php {
                $noteTagCollection = $response->getNoteTags();
                while ($noteTagCollection->hasNext()) {
            ?>
          <span class="label"><?php echo $noteTagCollection->current()->getUserTag()->getTag(); ?></span>
            <?php $noteTagCollection->next();
                }
}
    }
            ?>
      </td>
    </tr>
    <tr>
      <td><div><a href="/notes/create">Update</a></div></td>
      <td><div><a href="/notes"><button type="button">Back</button></a></div></td>
    </tr>
    </table>
    </fieldset>
</body>
</html>
