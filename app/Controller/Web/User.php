<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\User as UserService;
use Notes\Model\User as UserModel;
use Notes\Response\Response as Response;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class User
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Register.php";
        $view     = new View();
        $view     = $view->render($fileName);
    }
    public function post()
    {
        $input          = $this->request->getUrlParams();
        print_r($input);
        $userService = new UserService();
        try {
            $response = $userService->create($input);
        } catch (\InvalidArgumentException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response(200, "ok", "1.0.0", $response);
            $fileName    = "Register.php";
            $view        = new View();
            $view        = $view->render($fileName, $objResponse->getResponse());
        }
        catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response(200, "ok", "1.0.0", $response);
            $fileName    = "Register.php";
            $view        = new View();
            $view        = $view->render($fileName, $objResponse->getResponse());
        }
        if ($response instanceof UserModel) {
            header('Location: http://notes.com/login');
            exit();
        }
    }
}
