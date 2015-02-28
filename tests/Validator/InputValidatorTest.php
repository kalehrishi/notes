<?php

namespace Notes\Validator;

use Notes\PasswordValidation\PasswordValidator as PasswordValidator;

class InputValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testChecksForFiledIsNotEmpty()
    {
        $input = array(
            'userId' => 3
        );
        
        $validator = new InputValidator();
        $this->assertEquals(true, $validator->notNull($input));
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenFiledIsEmpty()
    {
        $input     = array();
        $validator = new InputValidator();
        $validator->notNull($input);
        
        
    }
    public function testChecksForValidId()
    {
        $input = array(
            'userId' => 3
        );
        
        $validator = new InputValidator();
        $this->assertEquals(true, $validator->validNumber($input['userId']));
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should be Number
     */
    public function testThrowsExceptionWhenIdIsNotNumber()
    {
        $input     = array(
            'userId' => "Test"
        );
        $validator = new InputValidator();
        $validator->validNumber($input['userId']);
        
    }
    public function testChecksForValidString()
    {
        $input = array(
            'firstName' => "test"
        );
        
        $validator = new InputValidator();
        $this->assertEquals(true, $validator->validString($input['firstName']));
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should be string
     */
    public function testThrowsExceptionWhenVariableIsNotString()
    {
        $input     = array(
            'firstName' => "@123"
        );
        $validator = new InputValidator();
        $validator->validString($input['firstName']);
        
    }
    public function testChecksEmailValidation()
    {
        $input = array(
            'email' => "Test@gamil.com"
        );
        
        $validator = new InputValidator();
        $this->assertEquals(true, $validator->validEmail($input['email']));
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Invalid Email
     */
    public function testThrowsExceptionWhenInvalidEmail()
    {
        $input     = array(
            'email' => "test.com"
        );
        $validator = new InputValidator();
        $validator->validEmail($input['email']);
        
    }
    public function testValidPassword()
    {
        $input     = array(
            'password' => "abc@$#A123"
        );
        $validator = new InputValidator();
        $this->assertEquals(true, $validator->isValidPassword($input['password']));
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Password Strength is weak
     */
    
    public function testThrowsExceptionWhenInvalidPassword()
    {
        $input     = array(
            'password' => "abc@123"
        );
        $validator = new InputValidator();
        $validator->isValidPassword($input['password']);
        
    }
}
