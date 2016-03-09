<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CmsHistory */

$this->title = 'Create Cms History';
$this->params['breadcrumbs'][] = ['label' => 'Cms Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
