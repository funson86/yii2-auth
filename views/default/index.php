<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create ') . Yii::t('app', 'Auth Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'company_id',
                'value'=>function ($model) {
                        return $model->company->name;
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'company_id',
                        ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]
                    ),
                'visible' => (Yii::$app->user->identity->company_id == 1),
            ],
            'name',
            'description',
            //'operation_list:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
