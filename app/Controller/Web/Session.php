<?php

namespace Notes\Controller\Web;
use Notes\View\View as View;
use Notes\Service\Session as SessionService;
class Session
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Login.php";
        $view     = new View();
        $view     = $view->render($fileName,$this->request);
    }

    public function post()
    { 
        //print_r($this->request->getData());
        $input=$this->request->getData();

        $sessionService = new SessionService();
        try{
          $response=$sessionService->login($input);
        }catch(ModelNotFoundException $e) {
          $fileName = "Login.php";
          $view     = new View();
          $view     = $view->render($fileName,$e);
        }

        if(get_class ($response)== 'Notes\Model\Session'){
          echo "redirecting";
          //redirect to some other page
          header("Location: http://notes.com/notes");
        }
        
    }
}
