<?php

namespace Notes\Encodeable;

use Notes\Model\User as UserModel;

class Encodeable extends UserModel
{
    public function encode($object)
    {
        
        $result     = array();
        $references = array();
        
        foreach ($object as $key => $value) {
            if (is_object($value) || is_array($value)) {
                if (!in_array($value, $references)) {
                    $result[$key] = object_to_array($value);
                    $references[] = $value;
                }
            } else {
                $result[$key] = $value;
            }
        }
        return json_encode($result);
    }
}
