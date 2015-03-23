<?php

namespace Notes\Model;

class Model
{
    /**
    * @return array
    */
    public function toArray()
    {
        return (get_object_vars($this));
    }
}
