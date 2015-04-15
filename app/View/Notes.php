<?php
session_start();
$data = json_decode($response, true);
?>
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
    <button type="button" style="margin:20px">Create</button>
    <a href="logout">Logout</a>
    <?php
    if (is_string($data['data'])) {
        echo "<h3>" . $data['data'] . "</h3>";
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
          for ($i = 0; $i < count($data['data']); $i++) {
                $id    = $data['data'][$i]['id'];
                $title = $data['data'][$i]['title'];
              ?>
              <tr align="center">
              <td><?php echo $id;
              ?>
              </td>
              <td><a href="/notes/Note.php?id=<?php echo $id;?>">

              <?php echo $title;?></a>
              </td> 
              <td><a href="">Delete</a></td>
              </tr>
              <?php
          }
    }
    ?>
            </table>
            </body>
            </html>