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
    <td class="ng-binding"><?= Html::encode($model->id); ?></td>
    <td class="ng-binding"><?= Html::encode($model->openid);?></td>

    <td class="ng-binding"><?= Html::encode($model->refer_openid );?></td>
    <td class="ng-binding"><?= Html::encode($model->insert_time); ?></td>
</tr>