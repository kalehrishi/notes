<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

use Notes\Model\User as UserModel;

class UserTag
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }
    public function get()
    {
        $test  = "test";
        $json =  json_encode($test);
        echo $json;
    }
}
