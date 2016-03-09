<?php

use backend\assets\CmsAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cms */

//CmsAsset::register($this);
//GridViewAsset::register($this);

$this->title = 'Update Cms: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-update">
    <section class="ng-scope">
        <div ui-view="" autoscroll="false" class="content-wrapper ng-scope ng-fadeInUp">
            <h3 class="ng-binding ng-scope"><?=\Yii::t('app','编辑模板');?></h3>


<!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form', [
                'model' => $model,
                'activity' => $activity,
            ]) ?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'desc',
        'time:datetime',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{set}',
            'buttons' => [
                'set' => function($url,$model,$key){
                    $url = "javascript:void(0);";
                    $options = [
                      'title' => Yii::t('yii', 'Set'),
                      'aria-label' => Yii::t('yii', 'Set'),
                      'data-pjax' => '0',
                      'name' => 'setTemplate_'.$model->id,
                    ];
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                },
            ],
        ],
    ],
    'layout' => '{items}',
]); ?>
<?php
$js = "jQuery('[name^=\"setTemplate_\"]').click(function(){var url = '". Url::toRoute(['cmshistory/gettemplate']) ."';
        var obj = jQuery(this).attr('name').split('_');
        $.ajax({  
            url:url,   
            type : 'POST',  
            data : {id:obj[1]},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {
                editor.getDoc().setValue(mydata);
                editor.refresh();
            },
            error : function() {  
                    alert('calc failed');  
            }  
        }); });";
$this->registerJs($js);
?>
</script>

        </div>
    </section>

</div>
