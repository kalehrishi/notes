<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Request\Request as Request;
use Notes\Factory\Layout as Layout;

class Home
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }

    public function get()
    {
        $path = __DIR__ . '/../../../public/templates/';
        
        $home = file_get_contents($path.'home.mustache');
        $register = file_get_contents($path.'register.mustache');
        $login = file_get_contents($path.'login.mustache');
        $notes = file_get_contents($path.'notes.mustache');
        $createNote = file_get_contents($path.'createNote.mustache');
        
        $homeLayout = array(
            'meta' => array('title' => 'Home'),
            'style' => array(),
            'hidden' => array(
                            'home' => $home,
                            'register'=> $register,
                            'login'=> $login,
                            'notes' => $notes,
                            'createNote' => $createNote
                            ),
            'script' => array(),
            'header' => array(),
            'content' => array(
                "h1"=> "Wel-come to Sticky-notes",
                "register"=> "New User:Register",
                "login"=> "Login"
                ),
            'footer' => array('year' => '2015', 'appName' => 'Notes')
            );
        
        $contentTemplateName = 'home';

        echo $this->view->renderPage($contentTemplateName, $homeLayout);
    }
}
