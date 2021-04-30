<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\mall\Favorite as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\mall\Favorite */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Favorites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card favorite-view">
    <div class="card-header">
        <?= Html::a(Yii::t('app', 'Update'), ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box'],
            'attributes' => [
                'id',
                'store_id',
                'user_id',
                'product_id',
                'type',
                'sort',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
                'created_by',
                'updated_by',
            ],
        ]) ?>

    </div>
</div>