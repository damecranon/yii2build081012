<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gender $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * behavior to control time stamp, don't forget to use statement for expression
     */
    public function behaviors() {
        return [
          'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
              ActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'updated_at'],
              ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],

              'value' => new Expression('Now()'),
            ],
          ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'gender_id'], 'required'],
            [['id', 'user_id', 'gender_id'], 'integer'],
            [['gender_id'], 'in', 'range' =>array_keys($this->getGenderList())],
            [['first_name', 'last_name'], 'string'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['birthdate'], 'date', 'format'=>'Y-m-d'],
            // use if error happens[['birthdate'], 'date', 'format'=>'php:Y-m-d'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birthdate',
            'gender_id' => 'Gender ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            //'genderName' => Yii::t('app', 'Gender'),
            //'userLink' => Yii::t('app', 'User'),
            //'profileIdLink' => Yii::t('app', 'Profile')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenderName(){
        return $this->gender->gender_name;
    }

    /**
     * Get list of genders from drop down
     */

    public static function getGenderList() {
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * get user name
     */
    public function getUserName(){
        return $this->user->username;
    }
    /**
     * @getUserId
     */
    public function getUserId() {
        return $this->user ? $this->user_id : 'none';
    }

    /**
     * @getUserLink
     */
      public function getUserLink() {
        $url = Url::to(['user/view', 'id'=> $this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }

    /**
     * @getProfileLink
     */
    public function getProfileLink() {
        $url = Url::to(['profile/link', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

    public function beforeValidate(){
        if ($this->birthdate != null) {
            $new_date_format = date('Y-m-d', strtotime($this->birthdate));
            $this->birthdate = $new_date_format;
        }

        return parent::beforeValidate();
    }
}
