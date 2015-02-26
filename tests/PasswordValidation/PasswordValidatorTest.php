<?php
namespace Notes\PasswordValidation;

class PasswordValidatorTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCanNotBeEmpty()
    {
        $obj = new PasswordValidator("");
        $this->assertEquals(true, $obj->isEmpty());
    }
    public function testAcceptCorrectPassword()
    {
        $obj = new PasswordValidator("anu.Hdf588");
        $this->assertEquals("anu.Hdf588", $obj->getPassword());
    }
    public function testLengthIsLongerThanSixCharacter()
    {
        $obj = new PasswordValidator("a@34ssk23");
        $this->assertEquals(true, $obj->isLengthLongerThanLimit());
    }
    public function testLengthIsEqualToLimit()
    {
        $obj = new PasswordValidator("t@3HfF");
        $this->assertEquals(true, $obj->isLengthLongerThanLimit());
    }
    public function testLengthShouldNotAcceptLessThanLimit()
    {
        $obj = new PasswordValidator("t@4fF");
        $this->assertEquals(false, $obj->isLengthLongerThanLimit());
    }
    public function testContainsOneUpperCaseCharacter()
    {
        $obj = new PasswordValidator("asFit#34F5");
        $this->assertEquals(true, $obj->hasUpperCaseCharacter());
    }
    public function testMustContainsOneUpperCaseCharacter()
    {
        $obj = new PasswordValidator("fsi1t#d5");
        $this->assertEquals(false, $obj->hasUpperCaseCharacter());
    }
    public function testContainsOneDigit()
    {
        $obj = new PasswordValidator("3asFit@34F5");
        $this->assertEquals(true, $obj->hasDigit());
    }
    public function testMustContainsOneDigit()
    {
        $obj = new PasswordValidator("asF%it@gdf");
        $this->assertEquals(false, $obj->hasDigit());
        $obj = new PasswordValidator("At@gdf");
        $this->assertEquals(false, $obj->hasDigit());
        
    }
    
    public function testContainsOneSpecialChararacter()
    {
        $obj = new PasswordValidator("asFit@3_5G");
        $this->assertEquals(true, $obj->hasSpecialCharacter());
        $obj = new PasswordValidator("~Ayuhgh99");
        $this->assertEquals(true, $obj->hasSpecialCharacter());
    }
    public function testMustContainsOneSpecialChararacter()
    {
        $obj = new PasswordValidator("asFit35G");
        $this->assertEquals(false, $obj->hasSpecialCharacter());
        $obj = new PasswordValidator("fj48DFr");
        $this->assertEquals(false, $obj->hasSpecialCharacter());
    }
    public function testStrengthVeryStrong()
    {
        $obj = new PasswordValidator("anushA@h21");
        $this->assertEquals(4, $obj->strength());
    }
    public function testStrengthStrong()
    {
        $obj = new PasswordValidator("aAhe2ggdf");
        $this->assertEquals(3, $obj->strength());
    }
    public function testStrengthVeryWeak()
    {
        $obj = new PasswordValidator("affg$");
        $this->assertEquals(1, $obj->strength());
    }
    public function testStrengthWeak()
    {
        $obj = new PasswordValidator("afdsg@h");
        $this->assertEquals(2, $obj->strength());
    }
    public function testIsEmpty()
    {
        $obj = new PasswordValidator("");
        $this->assertEquals(0, $obj->strength());
    }
    public function testStrengthIsComman()
    {
        $obj = new PasswordValidator("welcom@234");
        $this->assertEquals(0, $obj->strength());
        
    }
    
    public function testIsComman()
    {
        $obj = new PasswordValidator("welcom@234");
        $this->assertEquals(true, $obj->isCommanPassword());
        $obj = new PasswordValidator("google.com");
        $this->assertEquals(true, $obj->isCommanPassword());
        $obj = new PasswordValidator("general#127");
        $this->assertEquals(true, $obj->isCommanPassword());
    }
    public function testIsNotComman()
    {
        $obj = new PasswordValidator("gene#127");
        $this->assertEquals(false, $obj->isCommanPassword());
    }
}
