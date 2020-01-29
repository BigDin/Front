<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Access;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'firstname', 'lastname', 'password', 'email'], 'required', 'message' => 'Поле обязательное для заполнения'],
            ['email', 'email', 'message' => 'Неверный E-mail адрес'],
            ['username', 'unique', 'message' => 'Пользователь с таким логином уже зарегистрирован'],
            ['email', 'unique', 'message' => 'Пользователь с таким E-mail адресом уже зарегистрирован'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username'  => 'Логин',
            'firstname' => 'Имя',
            'lastname'  => 'Фамилия',
            'password'  => 'Пароль',
            'email'     => 'E-mail',
        ];
    }
    
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->getAttribute('password'));
        //return $this->password === $password;
    }
    
    public function getAccesses(){
        return $this->hasMany(Access::className(), ['user_id' => 'user_id']);
    }
        
    public function add()
    {
        
        $this->status = 1;
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        $this->access_token = Yii::$app->getSecurity()->generateRandomString();
        
        return parent::save();
    }
    
}