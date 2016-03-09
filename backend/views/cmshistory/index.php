<?php

use backend\assets\CmsAsset;
use yii\grid\GridViewAsset;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

CmsAsset::register($this);
GridViewAsset::register($this);

$this->title = 'Cms Histories';
$this->params['breadcrumbs'][] = ['label' => 'Cms', 'url' => ['cms/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <!-- Main section-->
    <section class="ng-scope">
        <div ui-view="" autoscroll="false" class="content-wrapper ng-scope ng-fadeInUp">
            <h3 class="ng-binding ng-scope"><?=\Yii::t('app','模板历史版本');?><small></small></h3>

            <!-- ngRepeat + ngResource-->
            <div class="panel panel-default ng-scope">
                
                <div class="panel-body">
                    <?= Html::a(Yii::t('app','返回列表'), Url::previous(), ['class' => 'btn btn-primary mb-sm']) ?>
                    <div ng-controller="SalesController" class="ng-scope">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                            <div class="dataTables_length" id="DataTables_Table_0_length">
                                <label>
                                    Show 
                                    <?= Html::dropDownList(
                                            'pagesize',
                                            $pagesize,
                                            [
                                                '1'=>1,
                                                '10'=>10,
                                                '25'=>25,
                                                '50'=>50,
                                                '100'=>100
                                            ]
                                    ); ?>
                                    entries
                                </label>
                            </div>
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <label>
                                    Search:<!--<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0">-->
                                    <?= Html::activeTextInput($searchModel, 'desc'); ?>
                                </label>
                            </div>
                            <table datatable="ng" class="row-border hover ng-isolate-scope dataTable no-footer" style="display: table;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="catalogId: activate to sort column descending" style="width: 280px;"><?=\Yii::t('app','活动');?></th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="name: activate to sort column ascending" style="width: 194px;"><?=\Yii::t('app','描述');?></th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 439px;"><?=\Yii::t('app','日期');?></th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="shortdescription: activate to sort column ascending" style="width: 439px;"><?=\Yii::t('app','操作');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    echo ListView::widget([  
                                        'dataProvider' => $dataProvider,  
                                        'itemView' => '_item',//子视图
                                        'options' => [
                                            'class' => 'dataTables_info',
                                            'id' => 'DataTables_Table_0_info',
                                            'role' => 'status',
                                            'aria-live' => 'polite',
                                        ],
                                        'layout' => '{items}',
                                        'showOnEmpty' => true,
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
                                <?=  LinkPager::widget([
                                    'pagination' => $dataProvider->getPagination(),
                                    'options' => ['style' => 'margin:0','class'=>'pagination'],
                                ]);?>
                            </div>
                        </div>
                        <h3 class="dt-loading" style="display: none;">Loading...</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->registerJs("jQuery('#DataTables_Table_0_wrapper').yiiGridView($options);"); ?>
