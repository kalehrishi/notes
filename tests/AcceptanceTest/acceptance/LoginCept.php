<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('login in with valid account');
$I->amOnPage("/");

$I->seeLink('Login');
$I->seeLink('New User:Register');

$I->click(['link' => 'Login']);

$I->fillField('email', 'gau@bhapkar.com');
$I->fillField("password", 'Gauri@123');

$I->click('Login');
$I->dontSeeElement('.error');
$I->seeInCurrentUrl('/notes');


$I = new AcceptanceTester($scenario);

$I->wantTo('login in with valid account');
$I->amOnPage("/");

$I->seeLink('Login');
$I->seeLink('New User:Register');

$I->click(['link' => 'Login']);

$I->fillField('email', 'gau@bhapkar.com');
$I->fillField("password", 'Gauri');

$I->click('Login');

$I->seeInCurrentUrl('/login');
$I->cantSeeInField('email', 'gau@bhapkar.com');
$I->cantSeeInField('password', 'Gauri');
$I->see('Error :-');
$I->see('Password Strength is weak');

?>