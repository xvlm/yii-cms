<?php

use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<tr class="ng-scope odd" role="row">
    <!--<td class="sorting_1"><?= Html::a(Html::encode($model->id), ['view', 'id' => $model->id], ['class' => 'ng-binding' , 'data-pjax' => 0]) ?></td>-->

    <td class="ng-binding"><?= $index + 1; ?></td>
    <td class="ng-binding"><?= Html::a(Html::encode($model->desc), ['cms/onlinepreview', 'view' => $model->view, 'activity' => $model->activity, 'platform' => $model->platform], ['target' => '_blank', 'title' => '浏览' , 'data-pjax' => 0]); ?></br>(<?=Html::encode($model->view)?>)</td>

<!--<td class="ng-binding"><?= Html::encode($model->view); ?></td>-->
<!--<td class="ng-binding"><?= Html::encode($model->layout); ?></td>-->

    <td class="ng-binding"><?= Html::encode($model->activity ? Yii::t('app',yii::$app->params['activityConf'][$platform][$model->activity]['name']) : Yii::t('app','无')); ?></br>(<?=Html::encode($model->activity)?>)</td>
    <td class="ng-binding"><?= Html::encode(Yii::t('app',Yii::$app->params['cmsStatusConf'][$model->status])) ?></td>
    <td class="ng-binding"><?= yii::$app->formatter->asDateTime($model->time, 'php:Y-m-d H:i:s'); ?></td>

    <td calss="ng-binding">
        <?= Html::a(Yii::t('app','编辑'), ['cms/update', 'id' => $model->id], ['data-pjax' => 0]); ?>
        &nbsp;&nbsp;
        <?= Html::a(Yii::t('app','预览'), ['cms/preview', 'view' => $model->view, 'platform' => $model->platform], ['target' => '_blank' , 'data-pjax' => 0]); ?>
        &nbsp;&nbsp;
        <?= Html::a(Yii::t('app','复制'), ['cms/copy', 'id' => $model->id], ['data-pjax' => 0]); ?>
        
            
        <?php
        if($model->status == '0'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','发布')), ['cms/release', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定发布?')] , 'data-pjax' => 0]);
        }else if($model->status == '1'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','撤消发布')), ['cms/unrelease', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定撤消?')] , 'data-pjax' => 0]);
        }else if($model->status == '2'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','重新发布')), ['cms/release', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定更新?')] , 'data-pjax' => 0]);
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','撤消发布')), ['cms/unrelease', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定撤消?')] , 'data-pjax' => 0]);
        }
        /*if($model->is_static == '0' && $model->status > '0'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode('静态化'), ['cms/static', 'view' => $model->view, 'id' => $model->id], ['data' => ['confirm' =>'确定静态化?',]]);
        }
        if($model->is_static == '1' && $model->status > '0'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode('更新静态化'), ['cms/updatestatic', 'platform'=>$model->platform, 'view' => $model->view, 'activity' => $model->activity], ['data' => ['confirm' => '立即更新?',]]);
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode('取消静态化'), ['cms/static', 'view' => $model->view, 'id' => $model->id], ['data' => ['confirm' => '确定取消?',]]);
        }*/
        if($model->is_cache == '0' && $model->status > '0'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','启用缓存')), ['cms/cache', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定启用?'),] , 'data-pjax' => 0]);
        }else if ($model->is_cache == '1' && $model->status > '0'){
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::encode(Yii::t('app','关闭缓存')), ['cms/uncache', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定关闭?'),] , 'data-pjax' => 0]);
        }
        ?>
        &nbsp;&nbsp;
        <?= Html::a(Yii::t('app','历史版本'), ['cmshistory/index', 'CmsHistorySearch[cms_id]' => $model->id] , ['data-pjax' => 0]); ?>
        &nbsp;&nbsp;
        <?= Html::a(Yii::t('app','删除'), ['cms/delete', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app','确定删除?'),] , 'data-pjax' => 0]); ?>
    </td>
</tr>