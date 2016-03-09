<?php

use backend\assets\CmsAsset;
use yii\grid\GridViewAsset;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use frontend\widgets\Alert;
use yii\widgets\Pjax;

//CmsAsset::register($this);
GridViewAsset::register($this);
?>
<!-- Main section-->
<section class="ng-scope">
    <div ui-view="" autoscroll="false" class="content-wrapper ng-scope ng-fadeInUp">
        <div class="row">
            <div class="col-md-8">
                <h3 class="ng-binding ng-scope">
                    <?= \Yii::t('app', '模板管理'); ?>
                    <small>
                        您正在访问的是
                        <?php
                        if ($platform == '1')
                            echo Html::tag('span','PC版');
                        else
                            echo Html::tag('span','移动版');
                        ?>
                    </small>
                </h3>
            </div>
            <div class="col-md-4"><?php
                if (Yii::$app->language == 'en-US')
                    echo Html::a('中文版', ['cms/language', 'locale' => 'zh-CN']);
                else
                    echo Html::a('English', ['cms/language', 'locale' => 'en-US']);
                ?>
                |
                <?php
                if ($platform == '1')
                    echo Html::a('移动版', ['cms/platform', 'platform' => '2']);
                else
                    echo Html::a('PC版', ['cms/platform', 'platform' => '1']);
                ?>
            </div>
        </div>

        <!-- ngRepeat + ngResource-->
        <div class="panel panel-default ng-scope">
            <div class="panel-heading">
                <?= \Yii::t('app', '模板管理'); ?>
            </div>
            <div class="panel-body">
                <?= Html::a(\Yii::t('app', '创建模板'), ['create'], ['class' => 'btn btn-primary mb-sm']) ?>
                <?php Pjax::begin(['options' => ['id' => 'DataTables_Table_0_wrapper']]); ?>
                <div ng-controller="SalesController" class="ng-scope">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <div class="dataTables_length" id="DataTables_Table_0_length">
                            <label>
                                <?= \Yii::t('app', '显示'); ?>
                                <?=
                                Html::dropDownList(
                                        'pagesize', $pagesize, [
                                    '1' => 1,
                                    '10' => 10,
                                    '25' => 25,
                                    '50' => 50,
                                    '100' => 100,
                                        ]
                                );
                                ?>
                                <?= \Yii::t('app', '条'); ?>
                            </label>
                        </div>
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <label>
                                <?= \Yii::t('app', '搜索'); ?>:<!--<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0">-->
                                <?= Html::activeTextInput($searchModel, 'view'); ?>
                            </label>
                        </div>
                        <table datatable="ng" class="row-border hover ng-isolate-scope dataTable no-footer" style="display: table;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row"><!--<th class="sorting_asc  sorting"  ...-->
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="catalogId: activate to sort column descending" style="width: 74px;"></th>
                                    <th  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="name: activate to sort column ascending" style="width: 74px;"><?= \Yii::t('app', '在线预览'); ?></th>
                                    <th  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 74px;"><?= \Yii::t('app', '活动'); ?></th>
                                    <th  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 74px;"><?= \Yii::t('app', '发布状态'); ?></th>
                                    <th  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 154px;"><?= \Yii::t('app', '日期'); ?></th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 366px;"><?= \Yii::t('app', '操作'); ?></th>                                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo ListView::widget([
                                    'dataProvider' => $dataProvider,
                                    'itemView' => '_item', //子视图
                                    'options' => [
                                        'class' => 'dataTables_info',
                                        'id' => 'DataTables_Table_0_info',
                                        'role' => 'status',
                                        'aria-live' => 'polite',
                                    ],
                                    'layout' => '{items}',
                                    'showOnEmpty' => true,
                                    'viewParams' => [
                                        'platform' => $platform,
                                    ],
                                ]);
                                ?>
                            </tbody>
                        </table>
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                            <?php
                            echo ListView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => '{summary}',
                            ]);
                            ?>
                        </div>
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <?=
                            LinkPager::widget([
                                'pagination' => $dataProvider->getPagination(),
                                'options' => ['style' => 'margin:0', 'class' => 'pagination'],
                            ]);
                            Pjax::end();
                            ?>
                        </div>
                    </div>
                    <h3 class="dt-loading" style="display: none;">Loading...</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->registerJs("jQuery('#DataTables_Table_0_wrapper').yiiGridView($options);"); ?>