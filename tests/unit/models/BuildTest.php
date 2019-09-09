<?php


namespace tests\unit\models;


use app\models\Build;
use app\models\Project;
use app\tests\fixtures\ProjectFixture;
use Codeception\Util\Debug;
use yii\helpers\Console;
use yii\test\InitDbFixture;

class BuildTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'project' => [
                'class' => ProjectFixture::className(),
//                'dataFile' => codecept_data_dir() . 'project.php'
            ]
        ];
    }
    public function testNewBuild()
    {
        $project = $this->getProjects()['Project Test'];
        $project = Project::findOne($project['id']);
        $old_build_cnt = $project->build_cnt;
        Debug::debug($project);
        $build = $project->createNewBuild();

        expect($build)->isInstanceOf(Build::className());
        expect_not(empty($build->buildFolder));
        expect_that(file_exists(\Yii::getAlias($build->buildFolder)));
        expect($project->build_cnt)->equals($old_build_cnt + 1);
        expect($build->build_no)->equals($old_build_cnt + 1);
    }

    private function getProjects()
    {
        return require codecept_data_dir() . 'project.php';
    }


}