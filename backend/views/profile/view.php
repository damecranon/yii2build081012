<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = $model->user->username;

$show_this_nav = PermissionHelpers::requireMinimumRole('SuperUser');

$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && $show_this_nav) {
            echo Html::a('Update', ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']);}?>


        <?php if (!Yii::$app->user->isGuest && $show_this_nav) {
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);}?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attributes' => 'userLink', 'format' => 'raw'],
            'first_name',
            'last_name',
            'birthdate',
            'gender.gender_name',
            'created_at',
            'updated_at',
            'id',
        ],
    ]) ?>

</div>
