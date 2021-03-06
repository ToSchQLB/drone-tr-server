<?php

namespace tests\unit\models;

use app\models\Project;

class ProjectTest extends \Codeception\Test\Unit
{
    private $projekt_id;

    public function testImportFolderFunctions()
    {
        $project = new Project(['name' => 'test-123']);
        $project->save(false);

        $this->projekt_id = $project->id;

        expect_not(empty($project->token));
        expect(file_exists(\Yii::getAlias('@web/import/' . $project->token)))->bool('true');

        $token = $project->token;

//        expect_that('New Build creates Folder');

        $build = $project->createNewBuild();

        expect(
            file_exists(\Yii::getAlias('@web/import/' . $token . '/' . $build->id))
        )->bool(true);

        $project->delete();

        expect_not(file_exists(\Yii::getAlias('@web/import/' . $token)));

    }


}
