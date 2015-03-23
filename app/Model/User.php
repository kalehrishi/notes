<?php
namespace Notes\Model;

use Notes\Support\Arrayable as Arrayable;

class User implements Arrayable
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;
    protected $createdOn;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }
    public function getCreatedOn()
    {
        return $this->createdOn;
    }
    public function toArray()
    {
        return(get_object_vars($this));
    }
}
