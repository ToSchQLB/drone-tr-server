<?php


namespace app\tests\fixtures;


use yii\test\ActiveFixture;

class ProjectFixture extends ActiveFixture
{
    public $tableName = 'project';
    public $db        = 'db';

    public function getData()
    {
        return require codecept_data_dir() . 'project.php';
    }

}