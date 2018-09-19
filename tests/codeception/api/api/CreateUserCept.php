<?php use tests\codeception\api\ApiTester;
$I = new ApiTester($scenario);
$I->wantTo('perform actions and see result');


$I->seeResponseContainsJson([

]);