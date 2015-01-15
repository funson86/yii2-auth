<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AuthRole */

$this->title = Yii::t('app', 'Create ') . Yii::t('app', 'Auth Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-create">

    <?= $this->render('_form', [
        'model' => $model,
        'operations' => $operations,
    ]) ?>

</div>
