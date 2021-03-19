<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\mall\AttributeSet as ActiveModel;
use common\models\mall\Attribute;

/* @var $this yii\web\View */
/* @var $model common\models\mall\AttributeSet */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Attribute Set');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$mapAttributeIdLabel = Attribute::getIdLabel()
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    <table class="table table-hover">
                        <thead>
                        <tr class="row">
                            <th class="col-5">属性</th>
                            <th class="col-5">排序</th>
                            <th class="col-2">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->attributeSetAttributes as $item) { ?>
                            <tr id="<?= $item->attribute_id ?>" class="row">
                                <td class="col-5">
                                    <?= Html::dropDownList('Sub[attribute_id][]', $item->attribute_id, $mapAttributeIdLabel, [
                                        'class' => 'form-control name',
                                    ]) ?>
                                </td>
                                <td class="col-5">
                                    <?= Html::textInput('Sub[sort][]', $item->sort, [
                                        'class' => 'form-control sort',
                                    ]) ?>
                                </td>
                                <td class="col-2">
                                    <a href="javascript:void(0);" class="delete update"> <i class="icon ion-android-cancel"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr id="operation">
                            <td colspan="2"><a href="javascript:" id="add"><i class="icon ion-android-add-circle"></i> 选择属性 </a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::button(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'onclick' => 'beforeSubmit()']) ?>
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script id="addHtml" type="text/html">
    <tr class="row">
        <td class="col-5">
            <?= Html::dropDownList('Sub[attribute_id][]', 0, $mapAttributeIdLabel, [
                'class' => 'form-control name',
            ]) ?>
        </td>
        <td class="col-5">
            <?= Html::textInput('Sub[sort][]', '50', [
                'class' => 'form-control sort',
            ]) ?>
        </td>
        <td class="col-2">
            <?= Html::hiddenInput('Sub[id][]', '') ?>
            <a href="javascript:void(0);" class="delete"> <i class="icon ion-android-cancel"></i></a>
        </td>
    </tr>
</script>

<script>
    // 增加
    $('#add').click(function () {
        let html = template('addHtml', []);
        $('#operation').before(html);
    });

    // 删除
    $(document).on("click", ".delete", function () {
        $(this).parent().parent().remove()
    });
    
    function beforeSubmit() {
        var submit = true;
        $('.sort').each(function () {
            if (!$(this).val()) {
                fbPrompt('请填写排序内容');
                submit = false;
            }

            if (isNaN($(this).val())) {
                fbPrompt('排序只能为数字');
                submit = false;
            }
        })

        if (submit) {
            $('#w0').submit();
        }
    }
</script>
