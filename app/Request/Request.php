<?php

namespace Notes\Request;

class Request
{
    protected $headers;
    protected $cookies;
    protected $urlParams;
    protected $data;
    public function setData($data)
    {
        $this->data = json_decode($data, true);
    }
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }
    public function setUrlParams($urlParams)
    {
        $this->urlParams = $urlParams;
    }
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }
    
    public function getData()
    {
        return $this->data;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getUrlParams()
    {
        return $this->urlParams;
    }
    public function getCookies()
    {
        return $this->cookies;
    }
}
