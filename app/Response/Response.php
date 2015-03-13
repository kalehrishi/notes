<?php

namespace Notes\Response;

use Notes\Encodeable\Encodeable as Encodeable;

class Response extends Encodeable
{
    public function toJson($response)
    {
        return $this->encode($response);
    }
}
