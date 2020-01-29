<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Result;

/**
 * Description of ResultController
 *
 * @author anton
 */
class ResultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        $model = Result::find()->where([
            'record.type' => 'fast'
        ])->orderBy([
            'id' => SORT_DESC
        ]);
        $model->joinWith(['record']);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = Result::findById($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            if ($model->record_id) {
                return $this->redirect(['index']);
            }
            return $this->redirect(['modeling']);
        }
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionModeling()
    {
        $model = Result::find()->where([
            'record.type' => 'model'
        ])->orderBy([
            'front' => SORT_ASC
        ]);
        $model->joinWith(['record']);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);
        return $this->render('modeling', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAdd()
    {
        $model = new Result();
        if ($model->load(Yii::$app->request->post())) {
            $model->record_id = 1;
            $model->error = 0;
            $model->confirmed = true;
            $model->save();
            return $this->redirect(['modeling']);
        }
        return $this->render('add', ['model' => $model]);
    }
    
    public function actionChart()
    {
        $models = Result::find()->orderBy([
            'distance' => SORT_ASC
        ])->joinWith([
            'record'
        ])->all();
        $i = $j = 0;
        foreach ($models as $model) {
            if ($model->record->type == 'model') {
                $modeling[$j++] = [$model->distance, $model->front]; 
            } else {
                $result[$i++] = [$model->distance, $model->front];
            }
        }
        return $this->render('chart', ['result' => $result, 'modeling' => $modeling,]);  
    }

    protected function findModel($id)
    {
        if (($model = Result::findById($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не доступна');
    }
}
