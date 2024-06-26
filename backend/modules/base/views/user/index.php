<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\User as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ImageHelper;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::filterModal() ?>
                    <?= Html::createModal() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <div class="card-body">
                <?//= $this->render('@backend/views/site/_select', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'visible' => false,
                        ],

                        'id',
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'parent_id', 'value' => function ($model) { return $model->parent->name ?? '-'; }, 'filter' => Html::activeDropDownList($searchModel, 'parent_id', ActiveModel::getTreeIdLabel(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        // 'username',
                        ['attribute' => 'username', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->username; }, 'filter' => true,],
                        [
                            'attribute' => 'avatar',
                            'filter' => false, // 不显示搜索框
                            'format' => 'raw',
                            'value' => function ($model) {
                                return ImageHelper::fancyBox($model->avatar);
                            },
                        ],
                        // 'auth_key',
                        // 'token',
                        // 'access_token',
                        // 'password_hash',
                        // 'password_reset_token',
                        // 'verification_token',
                        'email:email',
                        'mobile',
                        // 'auth_role',
                        'name',
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        //'avatar',
                        // 'brief',
                        ['attribute' => 'sex', 'value' => function ($model) { return ActiveModel::getSexLabels($model->sex); }, 'filter' => Html::activeDropDownList($searchModel, 'sex', ActiveModel::getSexLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'area',
                        // 'address',
                        // 'birthday',
                        ['attribute' => 'remark', 'format' => 'raw', 'value' => function ($model) { return Html::field('remark', $model->remark); }, 'filter' => true,],
                        // 'message_count',
                        // 'coupon_count',
                        // 'login_count',
                        // 'last_login_at:datetime',
                        // 'last_login_ip',
                        ['attribute' => 'last_paid_at', 'format' => 'raw', 'value' => function ($model) { return $model->last_paid_at > 100 ? Yii::$app->formatter->asDatetime($model->last_paid_at) : '-'; }, 'filter' => true,],
                        'consume_count',
                        'consume_amount',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(null, true), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{edit-msg} {edit-login} {edit-reset-password} {view} {edit} {delete}',
                            'buttons' => [
                                'edit-msg' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('app', 'Message'), ['/base/msg/edit', 'user_id' => $model->id], ['class' => 'btn btn-sm btn-info']);
                                },
                                'edit-login' => function ($url, $model, $key) {
                                    if ($this->context->isSuperAdmin()) {
                                        return Html::buttonModal(['edit-login', 'id' => $model->id], Yii::t('app', 'Login'), ['class' => 'btn btn-sm btn-success'], false, true);
                                    }
                                },
                                'edit-reset-password' => function ($url, $model, $key) {
                                    return Html::buttonModal(['edit-ajax', 'id' => $model->id, 'view' => 'edit-reset-password'], Yii::t('app', 'Reset password'), ['class' => 'btn btn-sm btn-warning']);
                                },
                                'view' => function ($url, $model, $key) {
                                    return Html::viewModal(['view-ajax', 'id' => $model->id]);
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::edit(['edit', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id], Yii::t('app', 'Black List'));
                                },
                            ],
                            'headerOptions' => ['class' => 'action-column action-column-lg'],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->render('@backend/views/site/_filter', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>
