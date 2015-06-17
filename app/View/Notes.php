<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notes | Home</title>
  <style>
 .error { 
  }
 
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
        </script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript" src="../js/View/NotesView.js"></script>     
<script type="text/javascript" src="../js/Controller/NotesController.js"></script>
</head>
<body>

    <button class="btn"><a href="/notes/create">Create</a></button>
    <button class="btn"><a href="logout">Logout</a></button>
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
