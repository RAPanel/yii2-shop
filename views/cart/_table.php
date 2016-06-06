<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 13.10.2015
 * Time: 17:11
 */

use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $query, 'sort' => false, 'pagination' => false]),
    'layout' => '{items}',
    'columns' => [
        'item_id',
        [
            'label' => 'Наименование',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->data->name, $model->data->getHref(1, 1), ['target' => '_blank']);
            }
        ],
        'quantity',
        'price',
        [
            'label' => 'Сумма',
            'value' => function ($model) {
                return $model->price * $model->quantity;
            }
        ],
    ],
]);