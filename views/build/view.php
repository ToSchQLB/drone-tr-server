<?php

use app\models\Build;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $build Build */

?>

<h1 style="margin-top: 0;"><?= $build->project->name ?> Build <?= $build->build_no ?></h1>
<iframe src="<?= Url::to(['build/view-report', 'id' => $build->id])?>" frameborder="0" style="width: 100%; height:80vh; height: calc(100vh - 50px - 120px - 38px);"></iframe>
