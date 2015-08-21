<?php
$data = json_decode($response, true);

$m = new Mustache_Engine;
Mustache_Autoloader::register();

//Add Header
$title = array('title' => "Login");
$m->render('header.mustache', $title);

// Add middle container
$m->render('template.mustache');
if (is_string($data['data'])) {
		?> <p class='error'><?php echo $data['data']; ?></p>
<?php
   } 

//Add footer
$footer = array();
$m->render('footer.mustache', $footer);
?>

