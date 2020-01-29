<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegForm extends User
{
    public static function tableName(){
        return "user";
    }
    
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'firstname', 'lastname', 'password', 'email'], 'required'],
            ['email', 'email'],
            [['firstname', 'lastname'], 'string'],
            [['username', 'email'], 'unique']

        ];
    }
    
    public function reg()
    {
        
        $this->status = 1;
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        $this->access_token = Yii::$app->getSecurity()->generateRandomString();
        
        return parent::save();
    }
}
