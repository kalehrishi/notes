<?php
use Notes\Collection\Collection as Collection;

?>
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
        <td>Error :-  </td>
            <td><div class="error" >
            <?php echo $response; ?>
            </div></td>
         
      </tr>
        <?php
    } else {
        ?>
      <tr>
        <td class="title"><?php echo $response->getTitle(); ?></td> 
      </tr>
      <tr>
        <td><?php echo $response->getBody(); ?></td> 
      </tr>
      <tr>
        <td><?php
        if ($response->getNoteTags()->getTotal() < 0) {
            echo "No Tags";
        } else {
            $noteTagCollection = $response->getNoteTags();
            $i=0;
            while ($noteTagCollection->hasNext()) {
            ?>
            <span class="label">
            <?php
            echo $noteTagCollection->getRow($i)->getUserTag()->getTag();
            $noteTagCollection->next();
            ?>
            </span>
            <?php
            $i++;
            }
        }
?></td>
      </tr>
      <tr><td><button type="button">Update</button>
      <a href="/notes"><button type="button">Back</button></a></td></tr>

        <?php
    }
        ?>

    </table>
    </fieldset>
</body>
</html>
