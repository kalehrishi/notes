<?php

namespace Notes\Validator;

class InputValidator
{
    public function isEmpty($input)
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
    public function validId($input)
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
}
