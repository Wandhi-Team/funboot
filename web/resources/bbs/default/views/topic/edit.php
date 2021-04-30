<?php
// use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use common\models\bbs\Node;
use common\models\bbs\Topic as ActiveModel;

$this->title = Yii::t('app', 'Publish');

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?= $this->title ?>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12 p-0">
                    <?php if (!Yii::$app->request->get('id')) { ?>
                    <?= $form->field($model, 'node_id')->dropDownList(Node::getTreeIdLabel(0, false)) ?>
                    <?php } ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?php foreach ($metas as $meta) { ?>
                        <div class="form-group row field-topic-node_id">
                            <div class="col-sm-2 text-right"><label class="control-label" for="topic-node_id"><?= $meta->name ?></label></div>
                            <div class="col-sm-10"><?= Html::textInput("Meta[$meta->id]", $mapMetaIdContent[$meta->id] ?? '', ['class' => 'form-control']) ?></div>
                        </div>
                    <?php } ?>
                    <?php if ($model->format == ActiveModel::FORMAT_MARKDOWN) { ?>
                        <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class, []) ?>
                    <?php } else { ?>
                    <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, ['style' => 2]) ?>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 p-0 text-center">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary pl-3 pr-3']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
