<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\User as UserService;
use Notes\Factory\User as UserFactory;
use Notes\Model\User as UserModel;
use Notes\Response\Response as Response;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class User
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view= new View();
    }
    public function get()
    {
        $this->view->render("Register.php");
    }
    public function post()
    {
        $input          = $this->request->getUrlParams();
        
        $userService = new UserService();
        try {
            $response = $userService->create($input);
            if ($response instanceof UserModel) {
                $app = \Slim\Slim::getInstance('developer');
                $app->redirect("/login");
            }
        } catch (\InvalidArgumentException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response);
            $this->view->render("Register.php", $objResponse->getResponse());
        } catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response);
            $this->view->render("Register.php", $objResponse->getResponse());
        } catch (\Exception $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response);
            $this->view->render("Register.php", $objResponse->getResponse());
        }
    }
}
