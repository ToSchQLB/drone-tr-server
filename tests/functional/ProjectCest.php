<?php

class ProjectCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['project/create']);
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#project-form', []);
        $I->expectTo('see validations errors');
        $I->see('Name darf nicht leer sein.');
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#project-form', [
            'Project[name]' => 'TestProject',
        ]);
        $I->dontSeeElement('#contact-form');
        $I->see('TestProject', 'h1');
    }
}