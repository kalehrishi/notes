<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
        </script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
        
        <script type="text/javascript" src="../js/View/NoteModelView.js"></script>
        <script type="text/javascript" src="../js/Model/NoteModel.js"></script>
        <script type="text/javascript" src="../js/Controller/Controller.js"></script>
        
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.19/themes/cupertino/jquery-ui.css">

        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>

    <body>
    <h3><p id="output"></p></h3>
        <form method="post">
            <div id="comment_form" class="container">
                <div>Create Note :</div>
                <div>
                    <input type="text" id="title" placeholder="Title" required="">
                </div>
                <div>
                    <textarea rows="10" id="description" placeholder="Description"></textarea>
                </div>
                <div id="note-tags">
                    <input type="hidden" id="noteModel" name="noteModel" />
                </div>
                <input type="submit" value="Save" id="save">
                <a href="/notes">
                    <button type="button">Back</button>
                </a>
            </div>
        </form>
    </body>
</html>
