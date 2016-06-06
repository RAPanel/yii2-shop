<?php
/* @var $this yii\web\View */
use ra\admin\helpers\RA;
use yii\helpers\Html;

$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="header"><?= $this->title ?></h1>

<div class="basketPage">
    <? \yii\widgets\Pjax::begin(['id' => 'cart', 'linkSelector' => '.remove a']) ?>
    <?= Html::beginForm(); ?>
    <div class="table">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => \Yii::$app->cart->items]),
            'summary' => false,
            'showHeader' => false,
            'columns' => [
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'image'],
                    'value' => function ($model) {
                        return Html::img($model->data->getPhotoHref('50'));
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'name'],
                    'value' => function ($model) {
                        return Html::a($model->data->name, $model->data->getHref(), ['class' => 'title']);
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'cost'],
                    'value' => function ($model) {
                        $result = '';
                        $result .= Html::tag('div', Yii::$app->formatter->asCurrency($model->price));
                        return $result;
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'quantity'],
                    'value' => function ($model) {
                        return Html::tag('div', Html::textInput('count', $model->quantity, ['data-numeric' => true, 'data-id' => $model->item_id]) . Html::button('', ['class' => 'increase', 'data-numeric' => '+1']) . Html::button('', ['class' => 'decrease', 'data-numeric' => '-1']), ['class' => 'quantityField']);
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'cost'],
                    'value' => function ($model) {
                        return Yii::$app->formatter->asCurrency($model->price * $model->quantity);
                    }
                ],
                [
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'remove'],
                    'value' => function ($model) {
                        return Html::a('', ['remove', 'id' => $model->data->id]);
                    }
                ],
            ]
        ]) ?>
    </div>
    <div class="total">
        <div class="row">
            <div class="medium-6  columns text-right float-right ">
                <span class="price"><?= Yii::$app->formatter->asCurrency(\Yii::$app->cart->cost) ?></span>
            </div>
            <div class="medium-6  columns float-left">
                <div class="row">
                    <div class="large-6 columns t-right">
                        <?= Html::a('вернуться в магазин', ['back'], ['class' => 'backTo']) ?>
                    </div>
                    <div class="large-6 columns clean">
                        <?= Html::a('очистить корзину <span></span>', ['clear'], ['class' => 'clearCart']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::endForm() ?>
<? \yii\widgets\Pjax::end() ?>

<div class="descriptionBlock"><?= RA::info('cartHint') ?></div>

<?= $this->render('send', ['model' => new app\models\Order()]) ?>
