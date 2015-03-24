<?php

namespace Notes\Model;

class Model
{
    /**
     * @return array
     */
    public function toArray()
    {
      $object_array = get_object_vars($this);
        foreach ($object_array as $key => $value) {
            if (is_array($value)) {
              foreach($value as $index=>$object)
                { 
                    $value[$index]=$object->toArray();
                    $object_array[$key]=$value;
                } 
            } elseif(is_object($value)){
               $value=$value->toArray();
               $object_array[$key]=$value; 
            }
        }
        return($object_array);   

    }
}
