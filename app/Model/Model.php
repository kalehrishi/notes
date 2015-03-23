<?php

namespace Notes\Model;

Class Model
{
    /**
    * @return array
    * 
    */
    
    public function toArray()
    {
      return(get_object_vars($this));
    }
}
