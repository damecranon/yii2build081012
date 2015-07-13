<?php

namespace common\models;

use yii;

class RecordHelpers {

    public static function userHas($model_name) {
        $connection = \Yii::$app->db;
        $userId = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name WHERE user_id = :user_id";
        $command = $connection->createCommand($sql);
        $command->bindValue(":user_id", $userId);
        $result = $command->queryOne();

        if($result == null) {
            return false;
        } else {
            return $result['id'];
        }


    }
}