<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use conquer\codemirror\CodemirrorWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Cms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-form">
    <?php 
    $form = ActiveForm::begin(); 
    ?>
    
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'view',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>
    
    <div>
        <?= $form->field($model, 'activity')->dropDownList($activity,['id' => 'activity']); ?>
        <?= $form->field($model, 'search_url' ,  ['labelOptions' => ['id' => 'search_label', 'style' => 'display:none']])->textInput(['maxlength' => true ,'id' => 'search_url', 'style' => 'display:none;']) ?>
       
    </div>
    <span id="seoIcon">+</span><a id="seoButton" href="javascript:void(0)" style="font-weight: bold;">SEO信息</a>
    <?= $form->field($model, 'seo_title', ['labelOptions' => ['id' => 'seo_title_lable', 'style' => 'display:none']])->textinput(['maxlength' => true ,'id' => 'seo_title', 'style' => 'display:none;']) ?>
    <?= $form->field($model, 'seo_keywords', ['labelOptions' => ['id' => 'seo_keywords_lable', 'style' => 'display:none']])->textinput(['maxlength' => true ,'id' => 'seo_keywords', 'style' => 'display:none;']) ?>
    <?= $form->field($model, 'seo_description', ['labelOptions' => ['id' => 'seo_description_lable', 'style' => 'display:none']])->textinput(['maxlength' => true ,'id' => 'seo_description', 'style' => 'display:none;']) ?>
    
    <?= $form->field($model, 'template')->textArea() ?>
    
    <div class="form-group">
        <?= $form->field($model,'platform', ['template'=> '{input}'])->hiddenInput(); ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','确定') : Yii::t('app','确定'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','取消'), Url::previous(), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php $this->registerJs("
            $('#activity').change(function(){
                if(this.value == 'search'){
                    $('#search_label').show();
                    $('#search_url').show();
                }else{
                    $('#search_label').hide();
                    $('#search_url').hide();
                }
            });
            $('#seoButton').click(function(){
                var seo_icon = $('#seoIcon').html();
                if(seo_icon == '+'){
                    $(\"[id ^= 'seo_']\").show();
                    $('#seoIcon').html('-');
                }else{
                    $(\"[id ^= 'seo_']\").hide();
                    $('#seoIcon').html('+');
                }
            });
        ");?>
</div>
