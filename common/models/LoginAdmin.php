<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use common\models\PermissionHelpers;

class LoginAdmin extends Model {

    public function loginAdmin(){
        if(($this->validate()) && PermissionHelpers::requireMinimumRole('Admin', $this->getUser()->id))  {
            return Yii::$app->user->login($this->getUser(),
                $this->rememberMe ? 3600 * 24 * 30 : 0);

        } else {
            throw new NotFoundHttpException('You Shall Not Pass');
        }
    }

}