<?php
/**
 * Created by PhpStorm.
 * User: Toni.Schreiber
 * Date: 11.07.2018
 * Time: 13:31
 */

use yii\helpers\Url;

class AcceptanceHelper
{
    public static function login($I, $nutzer = 'test.admin')
    {
        $users = require codecept_data_dir() . 'login.php';
        $user  = $users[$nutzer];

        $I->amOnPage(Url::toRoute('/user/security/login'));
        $I->maximizeWindow();
        $I->see('Anmelden');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('#loginform-login', $user['login']);
        $I->fillField('#loginform-password', $user['password']);
        $I->click('form#LoginForm button.btn-primary');

        $I->wait(2);
    }

    /**
     * @param $I      AcceptanceTester
     * @param $model  \yii\db\ActiveRecord
     * @param $values array
     */
    public static function fillForm($I, $model, $values)
    {

        foreach ($values as $key => $value) {
            $I->fillField('#' . strtolower($model->formName() . '-' . $key), $value);
        }
    }


    /**
     * @param $I      AcceptanceTester
     * @param $model  \yii\db\ActiveRecord
     * @param $fields array
     */
    public static function checkEmptyFields($I, $model, $fields)
    {
        foreach ($fields as $field) {
            $I->see($model->getAttributeLabel($field) . ' darf nicht leer sein');
        }
    }

    /**
     * Fill out select2 option field
     *
     * @param \Codeception\Actor $I
     * @param string             $selector
     * @param string             $value
     *
     * @return void
     */
    public static function fillOutSelect2OptionField(Actor $I, $selector, $value)
    {
        $element = '#select2-' . $selector . '-container';

        $I->click($element);

        $searchField = '.select2-search__field';

        $I->waitForElementVisible($searchField);

        $I->fillField($searchField, $value);

        $I->pressKey($searchField, WebDriverKeys::ENTER);
    }
}