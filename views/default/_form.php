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

    <?php
    if(Yii::$app->user->identity->company_id == 1)
        echo $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'));
    else
        echo Html::activeHiddenInput($model, 'company_id', ['value' => Yii::$app->user->identity->company_id]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <table class="table table-striped table-bordered">
        <tbody>
        <?php foreach($operations as $operation) { ?>
        <tr data-key="4">
            <td width="150px">
                <!--input type="checkbox" id="goods" name="goods" value="1" suboperation="goods_manage,remove_back,cat_manage,cat_drop,attr_manage,brand_manage,comment_priv,goods_type,tag_manage,goods_auto,virualcard,picture_batch,goods_export,goods_batch,gen_goods_script" style="position: absolute; opacity: 0;"-->
                <?= Html::checkbox($operation['name'], false, ['label' => Yii::t('auth', $operation['name']), 'id'=>$operation['name'], 'suboperation'=> implode(',', array_keys($operation['sub']))]) ?>
                <!--script type="text/javascript">
                    $("input[name='<?= $operation['name'] ?>']").click(function(){alert('hehe');
                        $("input[value='virualcard']").attr("checked",$(this).attr("checked"));
                    });
                </script-->
                <!--script type="text/javascript">
                    $(function() {
                        $("#<?= $operation['name'] ?>").click(function() {alert('aa');
                            //$('input[name="subBox"]').attr("checked",this.checked);
                        });
                        /*var $subBox = $("input[name='subBox']");
                        $subBox.click(function(){
                            $("#checkAll").attr("checked",$subBox.length == $("input[name='subBox']:checked").length ? true : false);
                        });*/$("input[value=\'goods_manage\']").attr("checked", this.checked);
                    });$("#'.$operation['name'].'").attr("checked",$("input[value=\'goods_manage\']:checked"));
                    $("input[value=\'goods_manage\']").prop("checked", this.checked);
                </script-->
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
                <?php /*$this->registerJs(
                    '

                    $(document).click(function(e){
                       var target=e.target;
                       if(target.id="goods"){
                       alert("dd");
                       }
                    })
                     '
                );*/?>
            </td>
            <td><?php echo $form->field($model, '_operations')->checkboxList($operation['sub'], ['unselect' => null])->label(false); ?></td>
            <!--td><?php //echo Html::activeCheckboxList($model, '_operations', $operation['sub'], ['unselect' => null]); ?></td-->
        </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
