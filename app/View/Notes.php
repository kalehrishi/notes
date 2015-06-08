<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notes</title>
  <style>
 .error { 
  }
</style>

</head>
<body>       
    <a href="/notes/create">Create</a>
    <a href="logout">Logout</a>
    <?php
    if (empty($response)) {
        ?>
        <h3>
        <?php
          echo "Note Not Create Yet!!! Create A note";
            ?>
        </h3>
    <?php
    } else {
        ?>
        <table border="1" font-size="25px" width="500" style="margin:5px">
        <tr align="center">
          <td>Title</td>
          <td>Action</td>
        </tr>
        <?php
        while ($response->hasNext()) {
            $id    = $response->current()->getId();
            $title = $response->current()->getTitle();
            ?>
          <tr align="center">
          <td>
            <a href="/note/read/<?php echo $id; ?>"><span  class="title"><?php echo $title; ?></span></a>
          </td>
          <td>
            <form action="note/delete/<?php echo $id; ?>" method="post">
              <input type="hidden" name="_METHOD" value="DELETE"/>
              <input type="submit" value="Delete"/>
            </form>
          </td>
        </tr>
        <?php
        $response->next();
        }
    }
?>
</table>
</body>
</html>
