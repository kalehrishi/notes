<?php

namespace Notes\Request;

class Request
{
    protected $header;
    protected $cookie;
    protected $urlParam;
    protected $data;
    //protected $version = null;
    //protected $platform = null;
    
    public function __construct()
    {
        
    }
    public function setData($data)
    {
        $this->data = json_decode($data, true);
    }
    public function setHeader($header)
    {
        $this->header = $header;
    }
    public function setUrlParam($urlParam)
    {
        $this->urlParam = $urlParam;
    }
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }
    
    public function getData()
    {
        return $this->data;
    }
    public function getHeader()
    {
        return $this->header;
    }
    public function getUrlParam()
    {
        return $this->urlParam;
    }
    public function getCookie()
    {
        return $this->cookie;
    }
}
