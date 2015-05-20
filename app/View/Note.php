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
.tag {
  border: 1px solid black;
  background-color: yellow;
  border-radius: 1px;
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
      <td>Error :-</td>
      <td><div class="error" ><?php echo $response; ?></div></td>       
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
      <td><div class="tag"><?php if ($response->getNoteTags()->getTotal() < 0) {
              echo "No Tags";
} else ?></div>
            <?php {
                $noteTagCollection = $response->getNoteTags();
                while ($noteTagCollection->hasNext()) {
            ?>
          <div class="tag"><?php echo $noteTagCollection->getRow(0)->getUserTag()->getTag(); ?></div>
            <?php $noteTagCollection->next();
                }
}
    }
            ?>
      </td>
    </tr>
    <tr>
      <td><button type="button">Update</button>
      <a href="/notes"><button type="button">Back</button></a>
      </td>
    </tr>
    </table>
    </fieldset>
</body>
</html>