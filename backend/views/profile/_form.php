<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textarea(['rows' => 45]) ?>

    <?= $form->field($model, 'last_name')->textarea(['rows' => 45]) ?>

    <?= $form->field($model, 'birthdate')->widget(DatePicker::className(),
        [   'dateFormat' => 'yyyy-MM-DD',
            'clientOptions' =>
                ['yearFormat' => '-115:+0',
                    'changeYear' => true]
        ]) ?>

    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList,
        ['prompt' => 'Please Choose One']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
