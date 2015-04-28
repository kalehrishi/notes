<?php
$query=mysql_connect("localhost","root","developer");
mysql_select_db("notes-master",$query);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Freeze Search engine</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js">
    
</script>
</head> 
<body> 
<div id="content"> 
<?php $val=''; if(isset($_POST['submit'])) 
{ 
    if(!empty($_POST['tag'])) { 
        $val=$_POST['tag']; 
        } else { 
            $val=''; 
            } 
            } ?> 
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
            Search : <input type="text" name="tag" id="name" autocomplete="off" value="<?php echo $val;?>"> 
            <input type="submit" name="submit" id="submit" value="Search"> </form> 
            <div id="display"></div> 


            <?php if(isset($_POST['submit'])) { 
                if(!empty($_POST['tag'])) { 
                    $name=$_POST['tag']; 
                    $query3=mysql_query("SELECT * FROM UserTags WHERE tag LIKE '%$tag%'"); 

                    while($query4=mysql_fetch_array($query3)) { 

                        echo "<div id='box'>"; echo "<b>".$query4['tag']."</b>"; 

                        //echo "<div id='clear'></div>"; echo $query4['descr']; 

                        echo "</div>"; 
                        } 
                        } else { 
                            echo "No Results"; 
                            } 
                            } ?> 

                            </div> 

                            </body> </html>