<?php
namespace Notes\Validator;

class InputValidator
{
    public function notNull($input)
    {
        if (!empty($input)) {
            return true;
        } else {
            throw new \InvalidArgumentException("Input should not be null");
        }
    }
    public function validString($input)
    {
        if (preg_match('/[a-zA-Z]/', $input)) {
            return true;
        } else {
            throw new \InvalidArgumentException("Input should be string");
        }
    }
    public function validNumber($input)
    {
        
        if (filter_var($input, FILTER_VALIDATE_INT)) {
            return true;
        } else {
            throw new \InvalidArgumentException("Input should be Number");
        }
    }
    public function validEmail($value)
    {
       
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            throw new \InvalidArgumentException("Invalid Email");
        }
    }
    
    
    public function isValidPassword($password)
    {
       
        $obj   = new PasswordValidator($password);
        $count = $obj->strength();
        if ($count == 4) {
            return true;
        } else {
            throw new \InvalidArgumentException("Password Strength is weak");
            
        }
        
    }
}
