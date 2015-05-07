<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notes | Home</title>
  <style>
 .error { 
  }
</style>

</head>
<body>
  <button type="button"><a href="/notes/create">Create</a></button>

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
            <td colspan="3">All Notes</td>
          </tr>
          <tr align="center">
          <td>No.</td>
          <td>Title</td>
          <td>Action</td>
          </tr>
        <?php
        for ($i = 0; $i < count($response); $i++) {
            $id    = $response[$i]['id'];
            $title = $response[$i]['title'];
            $count = $i + 1;
            ?>
            <tr align="center">
            <td><?php
            echo $count;
            ?>
            </td>
            <td><a href="/notes/read/<?php
                echo $id;
                ?>">
            <?php
                echo $title;
                ?></a>
                </td>
                <td>
                <form action="notes/<?php echo $id; ?>" method="post">
                    <input type="hidden" name="_METHOD" value="DELETE"/>
                    <input type="submit" value="Delete"/>
                </form>
                </td>
                </tr>
        <?php
        }
    }
?>
</table>
</body>
</html>
