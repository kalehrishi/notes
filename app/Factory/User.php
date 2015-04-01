<?php

namespace Notes\Factory;

use Notes\Model\User as UserModel;
use Notes\Validator\InputValidator as InputValidator;

class User
{
    protected $userModel;
    protected $validator;
	  public function __construct()
	  {
		   $this->userModel = new UserModel();
		   $this->validator = new InputValidator();
    }
	public function read($input)
	{
		if(isset($input['id']))
   	    {
          $this->validator->validNumber($input['id']);
          
          $this->userModel->setId($input['id']);

        return $this->userModel;

        } else {
        	 throw new \InvalidArgumentException("Input should not be null");
        }

	}
	public function create($input)
	{
		if(isset($input['firstName'])
     	&& isset($input['lastName'])
   	    && isset($input['email'])
   	    && isset($input['password']))
   	   {
          
          $this->validator->validString($input['firstName']);
          $this->validator->validString($input['lastName']);
          $this->validator->validEmail($input['email']);
          $this->validator->isValidPassword($input['password']);

          
          $this->userModel->setFirstName($input['firstName']);
          $this->userModel->setLastName($input['lastName']);
          $this->userModel->setEmail($input['email']);   
          $this->userModel->setPassword($input['password']);
          $this->userModel->setCreatedOn($input['createdOn']);
           return $this->userModel;

       } else {
        	 throw new \InvalidArgumentException("Input should not be null");
        }

      
	}
	public function update($input)
	{
		if(isset($input['id'])
       	&& isset($input['firstName'])
     	&& isset($input['lastName'])
   	    && isset($input['email'])
   	    && isset($input['password'])
   	    && isset($input['createdOn']))
   	   {
          $this->validator->validNumber($input['id']);
          $this->validator->validString($input['firstName']);
          $this->validator->validString($input['lastName']);
          $this->validator->validEmail($input['email']);;
          $this->validator->isValidPassword($input['password']);

          $this->userModel->setId($input['id']);
          $this->userModel->setFirstName($input['firstName']);
          $this->userModel->setLastName($input['lastName']);
          $this->userModel->setEmail($input['email']);   
          $this->userModel->setPassword($input['password']);
          $this->userModel->setCreatedOn($input['createdOn']);
          return $this->userModel;
       } else {
        	 throw new \InvalidArgumentException("Input should not be null");
        }
		
	}

	public function login($input)
	{
		if(isset($input['email'])
   	      && isset($input['password']))
   	    {
          
          $this->validator->validEmail($input['email']);
          $this->validator->isValidPassword($input['password']);

        
          $this->userModel->setEmail($input['email']);   
          $this->userModel->setPassword($input['password']);
           return $this->userModel;
        } else {
        	 throw new \InvalidArgumentException("Input should not be null");
        }
	}
}
