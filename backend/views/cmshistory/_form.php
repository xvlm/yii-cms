<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CmsHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cms_id')->textInput() ?>

    <?= $form->field($model, 'template')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'view')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
