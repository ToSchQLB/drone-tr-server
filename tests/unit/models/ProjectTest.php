<?php

namespace tests\unit\models;

use app\models\Project;

class ProjectTest extends \Codeception\Test\Unit
{
    private $projekt_id;

    public function testBeforeSave()
    {
        $projet = new Project(['name' => 'test-123']);
        $projet->save(false);

        $this->projekt_id = $projet->id;

        expect_not(empty($projet->token));
        expect_that(file_exist(\Yii::getAlias('@web/import/'.$projet->token)));
    }

    public function testBeforeDelete()
    {
        $projet = Project::findOne($this->projekt_id);
        $token = $projet->token;

        expect_that(file_exist(\Yii::getAlias('@web/import/'.$token)));
        expect($projet)->isInstanceOf(Project::class);
        $projet->delete();

        not(file_exist(\Yii::getAlias('@web/import/'.$token)));
    }
}
