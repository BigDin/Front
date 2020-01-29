<?php

namespace app\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Record;
use app\models\RecordSearch;
use app\models\Result;
use app\models\Chart;
use app\models\Calculations;

/**
 * Description of RecordController
 *
 * @author anton
 */
class RecordController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionView($id)
    {
        $record = Record::findById($id);
        $info = new \app\models\BinInfo($record->info);
        $slowRecord = Record::findMatched(
            $info->readSeconds(),
            $info->readSamples()
        );
        if ($slowRecord) {
            $slowChart = new Chart($slowRecord);
            $infoSlow = new \app\models\BinInfo($slowRecord->info);
        } else {
            $slowChart = null;
        }
        $fastChart = new Chart($record);
        $result = Result::findByRecordId($fastChart->id);
        return $this->render('view', [
            'fastChart' => $fastChart, 
            'slowChart' => $slowChart,
            'result' => $result,
            'info' => $info,
            'infoSlow' => $infoSlow
        ]);
    }
}
