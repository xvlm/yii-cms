<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cms */

$this->title = 'Create Cms';
$this->params['breadcrumbs'][] = ['label' => 'Cms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-create">
    <section class="ng-scope">
        <div ui-view="" autoscroll="false" class="content-wrapper ng-scope ng-fadeInUp">
            <h3 class="ng-binding ng-scope"><?=\Yii::t('app','创建模板');?></h3>

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form', [
                'model' => $model,
                'activity' => $activity,
            ]) ?>
            </div>
    </section>
</div>
