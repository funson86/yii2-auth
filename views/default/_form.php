<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <table class="table table-striped table-bordered">
        <tbody>
        <?php foreach($operations as $operation) { ?>
        <tr data-key="4">
            <td width="150px">
                <?= Html::checkbox($operation['name'], false, ['label' => Yii::t('auth', $operation['name']), 'id'=>$operation['name'], 'suboperation'=> implode(',', array_keys($operation['sub']))]) ?>
                <?php
                $str = '';
                foreach($operation['sub'] as $key => $value)
                    $str .= '$("input[value=\'' . $key . '\']").prop("checked", this.checked);';
                $this->registerJs(
                '
                    $("#' . $operation['name'] . '").click(function() {
                        ' . $str . '
                    });
                '
                ); ?>
            </td>
            <td><?php echo $form->field($model, '_operations')->checkboxList($operation['sub'], ['unselect' => null])->label(false); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
