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
    <td class="sorting_1"><?= Html::encode(Yii::t('app',Yii::$app->params['activityConf'][$model->platform][$model->activity]['name'])); ?></td>
    <td class="ng-binding"><?= Html::a(Html::encode($model->desc), ['preview', 'view' => $model->id, 'platform' => $model->platform], ['target' => '_blank']);?></td>
    <td class="ng-binding"><?= yii::$app->formatter->asDateTime($model->time, 'php:Y-m-d h:m:s'); ?></td>
    <td calss="ng-binding">
        <?= Html::a(Yii::t('app','编辑'), ['update', 'id' => $model->cms_id , 'historyId' => $model->id]);?>
            &nbsp;&nbsp;|&nbsp;&nbsp;
        <?= Html::a(Yii::t('app','启用'), ['cms/set', 'id' => $model->cms_id , 'historyId' => $model->id]);?>
            <!--&nbsp;&nbsp;|&nbsp;&nbsp;-->
        
    </td>
</tr>