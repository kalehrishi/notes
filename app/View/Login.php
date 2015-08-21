<?php
$data = json_decode($response, true);

$m = new Mustache_Engine;
Mustache_Autoloader::register();

$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader('/vagrant/template/'),
));


//Add Header
$title = array('title' => "Login");
echo $m->render('header.mustache', $title);

// Add middle container
echo $m->render('template.mustache');
if (is_string($data['data'])) {
		echo "Error :-<p class='error'>" . $data['data'] ."</p>";
   } 

//Add footer
$footer = array();
echo $m->render('footer.mustache', $footer);
?>

