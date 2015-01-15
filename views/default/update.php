<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRole */

$this->title = Yii::t('app', 'Update ') . Yii::t('app', 'Auth Role') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auth-role-update">

    <?= $this->render('_form', [
        'model' => $model,
        'operations' => $operations,
    ]) ?>

</div>
