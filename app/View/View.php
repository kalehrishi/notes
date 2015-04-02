<?php

namespace Notes\View;

class View
{
    public function render($fileName, $response = null)
    {
        require_once __dir__ . "/$fileName";
    }
}
