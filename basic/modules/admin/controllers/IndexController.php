<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;
use app\models\Msg;
use app\models\Tcp;

/**
 * Description of IndexController
 *
 * @author anton
 */
class IndexController extends Controller 
{
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
    
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('padmin')) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest()
    {
        return $this->render('test');
    }
    
    public function actionFtp()
    {
        $path = Yii::$app->request->get('path');
        if(empty($path)){
            $path='';
        }
        $adapter = new SftpAdapter([
            'host' => '192.168.100.200',
            'port' => 22,
            'username' => 'pi',
            'password' => '28091691',
            'root' => '',
            'timeout' => 10,
            'directoryPerm' => 0755
        ]);
        $filesystem = new Filesystem($adapter);
        $dirs = $filesystem->listContents($path);
        if ($dirname = strrchr($path, '/')) {
            $backPath = str_replace($dirname, '', $path);
        } else {
            $backPath = null;
        }
        return $this->render('ftp', ['dirs' => $dirs, 'backPath' => $backPath]);
    }
    
    public function actionDownload()
    {
        $path = Yii::$app->request->get('path');
        $adapter = new SftpAdapter([
            'host' => '192.168.100.200',
            'port' => 22,
            'username' => 'pi',
            'password' => '28091691',
            'root' => '',
            'timeout' => 10,
            'directoryPerm' => 0755
        ]);
        $filesystem = new Filesystem($adapter);
        
        if (!$content=$filesystem->read($path)) {
            throw new Exception('Ошибка чтения файла');
        }
        if (Yii::$app->fs->put('/tmp/load.txt', $content)) {
            $file = Yii::getAlias('@webroot') . '/tmp/load.txt';
        } else {
            throw new Exception('Файл не загружен');
        }
        if (file_exists($file)) {
            return \Yii::$app->response->sendFile($file);
        } 
        return $this->render('error', ['message' => 'Что-то пошло не так :(']);
    }
    
    public function actionTcp()
    {
        $model = new Msg();
        $tcp = new Tcp();
        $port = 12700;
        $answer = '';
        if ($model->load(Yii::$app->request->post())) {
            $model->compile();
            $tcp->connect("192.168.100.200", $port);
            $tcp->send($model->buff);
            $tcp->read();
            $answer = $model->translate($tcp->msg);//$answer = $tcp->msg;
        }
        return $this->render('tcp', ['model' => $model, 'msg' => $tcp->msg, 'answer' => $answer, 'send' => $model->buff]);
    }
}
