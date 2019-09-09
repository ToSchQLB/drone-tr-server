<?php

namespace app\controllers;

use app\models\Project;
use app\models\ProjectSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('project', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionProcessBuild($token)
    {
        $project = Project::findOne(['token' => $token]);
        if (is_null($project)) {
            throw new NotFoundHttpException();
        }
        $build = $project->createNewBuild();
        FileHelper::copyDirectory(
            '.' . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . $project->token,
            $build->buildFolder
        );

        $data = simplexml_load_file($build->buildFolder . DIRECTORY_SEPARATOR . 'report.xml');
        echo '<pre>';

        $assertion = $pos = $neg = 0;
        foreach ($data->testsuite as $testsuite) {
            $attributes = $testsuite->attributes();
            $assertion  += $attributes['assertions'];
            $neg        += $attributes['errors'];
            $neg        += $attributes['failures'];
        }

        $build->success   = $neg == 0 ? 1 : 0;
        $build->assertion = $assertion;
        $build->positiv   = $pos;
        $build->negativ   = $neg;

        $build->save();
    }


}
