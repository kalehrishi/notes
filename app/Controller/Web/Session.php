<?php

namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;

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
        $input=$this->request->getUrlParams();

        $sessionService = new SessionService();
        try{
          $response=$sessionService->login($input);
        } catch(InvalidArgument $error) {
          echo "Error---".$error;
          /*$fileName = "Login.php";
          $view     = new View();
          $view     = $view->render($fileName,$e);
*/
        } 
        catch(ModelNotFoundException $error) {
          /*$fileName = "Login.php";
          $view     = new View();
          $view     = $view->render($fileName,$e);*/
        }

        if($response instanceof SessionModel) {
          echo "redirecting Test";
          //redirect to some other page
          header("Location: http://notes.com/notes");
        }
        
    }
}
