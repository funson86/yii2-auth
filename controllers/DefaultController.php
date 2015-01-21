<?php

namespace funson86\auth\controllers;

use Yii;
use funson86\auth\models\AuthRole;
use funson86\auth\models\AuthRoleSearch;
use funson86\auth\models\AuthOperation;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    /**
     * Lists all AuthRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can('viewRole')) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));

        $searchModel = new AuthRoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthRole model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can('viewRole')) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));

        $model = $this->findModel($id);

        $strOperation = '';
        $i = 0;
        if($model->operation_list)
        {
            $arrayOperation = explode(';', $model->operation_list);
            foreach($arrayOperation as $item)
            {
                $strOperation .= Yii::t('auth', $item) . ' | ';
                $i++;
                if($i % 5 == 0)
                    $strOperation .= "\n";
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'strOperation' => $strOperation,
        ]);
    }

    /**
     * Creates a new AuthRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('createRole')) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));

        $model = new AuthRole();

        if ($model->load(Yii::$app->request->post())) {
            $operations = $this->prepareOperations(Yii::$app->request->post());
            $model->operation_list = implode(';', $operations);

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //generate all operations
            $operations = [];
            $rootOperations = AuthOperation::find()->where(['parent_id' => 0])->all();
            foreach($rootOperations as $rootOperation)
            {
                $operations[$rootOperation->id]['name'] = $rootOperation->name;
            }
            $subOperations = AuthOperation::find()->where('parent_id <> 0')->all();
            foreach($subOperations as $subOperation)
            {
                $operations[$subOperation->parent_id]['sub'][$subOperation->name] = Yii::t('auth', $subOperation->name);
            }

            return $this->render('create', [
                'model' => $model,
                'operations' => $operations,
            ]);
        }
    }

    /**
     * Updates an existing AuthRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('updateRole')) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));
        if($id == 1) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $operations = $this->prepareOperations(Yii::$app->request->post());
            $model->operation_list = implode(';', $operations);

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //generate all operations
            $operations = [];
            $rootOperations = AuthOperation::find()->where(['parent_id' => 0])->all();
            foreach($rootOperations as $rootOperation)
            {
                $operations[$rootOperation->id]['name'] = $rootOperation->name;
            }
            $subOperations = AuthOperation::find()->where('parent_id <> 0')->all();
            foreach($subOperations as $subOperation)
            {
                $operations[$subOperation->parent_id]['sub'][$subOperation->name] = Yii::t('auth', $subOperation->name);
            }

            //generate selected operations
            $model->_operations = explode(';', $model->operation_list);

            return $this->render('update', [
                'model' => $model,
                'operations' => $operations,
            ]);
        }
    }

    /**
     * Deletes an existing AuthRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('deleteRole')) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));
        if(1 == $id) throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuthRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * prepare Operations
     * @param array $post
     * @return array 
     */
    protected function prepareOperations($post) {
        return (isset($post['AuthRole']['_operations']) &&
            is_array($post['AuthRole']['_operations'])) ? $post['AuthRole']['_operations'] : [];
    }
}
