<?php
use yii\grid\GridView;
use common\helpers\Html;
use common\enums\GenderEnum;

$this->title = '第三方用户';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //重新定义分页样式
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false, // 不显示#
                        ],
                        [
                            'attribute' => 'id',
                            'filter' => false, //不显示搜索框
                        ],
                        [
                            'attribute' => 'head_portrait',
                            'value' => function ($model) {
                                return Html::img(Html::headPortrait(Html::encode($model->head_portrait)), [
                                    'class' => 'img-circle rf-img-md img-bordered-sm',
                                ]);
                            },
                            'filter' => false,
                            'format' => 'raw',
                        ],
                        'nickname',
                        [
                            'attribute' => 'gender',
                            'value' => function ($model, $key, $index, $column){
                                return GenderEnum::$listExplain[$model->gender];
                            },
                            'filter' => Html::activeDropDownList($searchModel,
                                'gender',
                                GenderEnum::$listExplain,
                                [
                                    'prompt' => '全部',
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        'oauth_client',
                        [
                            'label'=> '关联用户',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return "用户ID：" . $model->member->id . '<br>'.
                                    "昵称：" . $model->member->nickname . '<br>'.
                                    "账号：" . $model->member->username . '<br>'.
                                    "手机：" . $model->member->mobile . '<br>';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'province',
                            'filter' => false, //不显示搜索框
                        ],
                        [
                            'attribute' => 'city',
                            'filter' => false, //不显示搜索框
                        ],
                        [
                            'attribute' => 'created_at',
                            'filter' => false, //不显示搜索框
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        // 'updated_at',
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template'=> '{ajax-edit} {address} {edit} {status} {destroy}',
                            'buttons' => [
                                'edit' => function ($url, $model, $key) {
                                    return Html::edit(['edit', 'id' => $model->id]);
                                },
                                'status' => function ($url, $model, $key) {
                                    return Html::status($model->status);
                                },
                                'destroy' => function ($url, $model, $key) {
                                    return Html::delete(['destroy','id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
