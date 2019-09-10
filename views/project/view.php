<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('project', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('project', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('project', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('project', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'token',
        ],
    ]) ?>

    <h2><?= Yii::t('project', 'last builds') ?></h2>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->builds,
            'sort'      => [
                'attributes'   => ['build_no', 'date', 'success'],
                'defaultOrder' => ['build_no' => SORT_DESC],
            ],
        ]),
        'columns'      => [
            [
                'attribute' => 'build_no',
                'format'    => 'raw',
                'value'     => function ($model) {
                    /** @var \app\models\Build $model */
                    return Html::a($model->build_no, ['build/view', 'id' => $model->id], ['target' => '_blank']);
                },
            ],
            'date:date',
            [
                'attribute' => 'success',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $model->success == 1 ?
                        Html::tag('span', 'yes', ['class' => 'label label-success']) :
                        Html::tag('span', 'no', ['class' => 'label label-danger']);
                },
            ],
        ],
    ]) ?>

</div>
