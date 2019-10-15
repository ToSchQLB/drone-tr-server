<?php


namespace app\controllers;


use app\models\Build;
use yii\filters\AccessControl;
use yii\web\Controller;

class BuildController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]

            ]
        ];
    }

    public function actionView($id)
    {
        $build = Build::findOne($id);
        if (is_null($build)) {
            echo 'nicht gefunden';
        }

        return $this->render('view', ['build' => $build]);
    }

    public function actionViewReport($id){
        $build = Build::findOne($id);
        if (is_null($build)) {
            echo 'nicht gefunden';
        }

        $report = file_get_contents($build->buildFolder . DIRECTORY_SEPARATOR . 'report.html');
        $report = str_replace("img src='", "img src='" . $build->buildFolder . DIRECTORY_SEPARATOR, $report);
        $report = str_replace("href='", "href='" . $build->buildFolder . DIRECTORY_SEPARATOR, $report);

        echo $report;
        die();
    }
}