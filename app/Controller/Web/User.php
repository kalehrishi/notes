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
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view= new View();
    }
    
    public function post()
    {
        $input          = $this->request->getData();
        $userService = new UserService();
        try {
            $response = $userService->create($input);
            if ($response instanceof UserModel) {
                $app = \Slim\Slim::getInstance('developer');
                
                $objResponse = new Response($response->toArray(), 1, "SUCCESS");
                echo $objResponse->getResponse();
            }
        } catch (\InvalidArgumentException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response, 0, "FAILURE");
            echo $objResponse->getResponse();
        } catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response, 0, "FAILURE");
            echo $objResponse->getResponse();
        } catch (\Exception $error) {
            $response    = $error->getMessage($response, 0, "FAILURE");
            $objResponse = new Response();
            echo $objResponse->getResponse();
        }
    }
}
