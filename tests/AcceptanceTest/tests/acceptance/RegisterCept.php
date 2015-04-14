<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('Register New User');
$I->amOnPage("/");

$I->seeLink('Login');
$I->seeLink('New User:Register');

$I->click(['link' => 'New User:Register']);

$I->fillField('firstName', 'Joy');
$I->fillField('lastName', 'Mock');
$I->fillField('email', 'joy@mock.com');
$I->fillField("password", 'Joymock@123');

$I->click('Submit');
$I->dontSeeElement('.error');
$I->seeInCurrentUrl('/login');

$I->fillField('email', 'joy@mock.com');
$I->fillField("password", 'Joymock@123');

$I->click('Login');

$I->seeInCurrentUrl('/notes');

?>