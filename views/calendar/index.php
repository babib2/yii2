<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Calendars');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Calendar'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'text',
            'create_at_date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Поделиться', Url::to(['/access/create/'.$model->id]));
                    },
                ],
            ],
        ],
    ]); ?>
</div>
