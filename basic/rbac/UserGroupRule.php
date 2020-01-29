<?php
namespace app\rbac;
 
use Yii;
use yii\rbac\Rule;
 
class UserGroupRule extends Rule
{
    public $name = 'userGroup';
 
    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $groups = \Yii::$app->user->identity->username;
            if ($item->name === 'admin') {
                return $groups == 'admin';
            } elseif ($item->name === 'BRAND') {
                return $groups == 'admin' || $groups == 'BRAND';
            } 
        }
        return true;
    }
}
