<?php
namespace common\models;


use common\models\ValueHelpers;
use yii;
use yii\web\Controller;
use yii\helpers\Url;

class PermissionHelpers {

    public static function requireUpgradeTo($user_type_name) {
        if(!ValueHelpers::userTypeMatch($user_type_name)) {
            return Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
        }
    }

    public static function requireStatus($status_name) {
        return ValueHelpers::statusMatch($status_name);
    }

    public static function requireRole($role_name){
        return ValueHelpers::roleMatch($role_name);
    }

    public static function requireMinimumRole($role_name, $userId = null) {
        if (ValueHelpers::isRoleNameValid($role_name)) {
            if ($userId == null) {
                $userRoleValue = ValueHelpers::getUserRoleValue();
            } else {
                $userRoleValue = ValueHelpers::getUserRoleValue($userId);
            }
            return $userRoleValue >= ValueHelpers::getRoleValue($role_name) ? true : false;
        } else {
            return false;
        }
    }

    public static function userMustBeOwner($model_name, $model_id) {

        $connection = \Yii::$app->db;

        $userId = Yii::$app->user->id;

        $sql = "SELECT id from $model_name
                  WHERE user_id = :user_id AND id = :model_id";

        $command = $connection->createCommand($sql);
        $command->bindValue(":user_id", $userId);
        $command->bindValue(":model_id", $model_id);

        if($result = $command->queryOne()){
            return true;
        } else {
            return false;
        }

    }


}

