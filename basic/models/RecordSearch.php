<?php


namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Record;
use yii\data\ActiveDataProvider;

class RecordSearch extends Record
{
    public $dateStart;
    public $dateEnd;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date_time', 'dateStart', 'dateEnd'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        if (Yii::$app->controller->module->id == 'admin') {
            $query = Record::find()->where([
                'not in', 
                'type', 
                ['model']
            ])->orderBy([
                'id' => SORT_DESC
            ]);
            $query->joinWith(['result']);
        } else {
            $query = Record::find()->where([
                'type' => 'fast'
            ])->orderBy([
                'id' => SORT_DESC
            ]);
            $query->joinWith(['result']);
        }
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию

        $query->andFilterWhere(['record.id' => $this->id]);
        $query->andFilterWhere(['between', 'date_time', $this->dateStart, $this->dateEnd]);

        return $dataProvider;
    }
}