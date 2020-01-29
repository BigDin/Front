<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
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
                //'only' => ['login', 'logout', 'signup'],
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
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionConfirm($id)
    {
        $model = Result::findById($id);
        $distance = $model->distance;
        if ($model->load(Yii::$app->request->post())) {
            $model->error = $distance - $model->distance;
            $model->confirmed = true;
            $model->save();
            return $this->redirect(['record/view', 'id' => $model->record_id]);
        }
        return $this->render('confirm', [
            'model' => $model,
        ]);
    }
}
