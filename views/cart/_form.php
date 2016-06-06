<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.09.2015
 * Time: 15:21
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (!\Yii::$app->cart->cost) return;

$radioFormat = function ($index, $label, $name, $checked, $value) {
    $id = trim(str_replace(['[', '}'], '_', $name), '_') . '_' . $index;
    return Html::radio($name, $checked, ['id' => $id, 'value' => $value]) . Html::label($label, $id, ['class' => 'val-' . \yii\helpers\Inflector::slug($value)]);
};
?>

<? $form = ActiveForm::begin([
    'action' => ['send'],
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => '<div class="line"><div class="row"><div class="large-4 medium-3 text-right columns">{label}</div><div class="large-4 medium-6 centerBlock columns">{input}</div><div class="large-4 medium-6 medium-offset-3 large-offset-0 columns end">{error}</div></div></div>',
        'labelOptions' => ['class' => ''],
    ],
]) ?>

    <div class="form">

        <?= $form->field($model, 'name'); ?>

        <?= $form->field($model, 'phone')->input('tel')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7 (999) 999-9999']); ?>

        <?= $form->field($model, 'email')->input('email'); ?>

        <?= $form->field($model, 'city')->textInput(['class' => 'autoCompleteCity']); ?>

        <?= $form->field($model, 'delivery_id')->radioList($model->deliveries, ['item' => $radioFormat])->label('Способ доставки'); ?>

        <div class="toggle hide" data-parent="Order[delivery_id]" data-value="[5,12]">
            <?= $form->field($model, 'address')->textarea(['rows' => 2]); ?>
        </div>

        <div class="toggle hide large-offset-4 medium-offset-3 deliveryCost" data-parent="Order[delivery_id]"
             data-value="[11,12]" data-callback="ajaxDelivery">

        </div>

        <?= $form->field($model, 'pay_id')->radioList($model->pais, ['item' => $radioFormat])->label('Способ оплаты'); ?>

        <div class="toggle hide" data-parent="Order[pay_id]" data-value="[9]">
            <?= $form->field($model, 'paymentType')->radioList(Yii::$app->merchants->get('yandex')->getAllowedPaymentTypes(), ['item' => function ($index, $label, $name, $checked, $value) {
                $id = trim(str_replace(['[', '}'], '_', $name), '_') . '_' . $index;
                return Html::radio($name, $checked, ['id' => $id, 'value' => $value]) . Html::label('<span class="ico"></span> <span class="title">' . $label . '</span>', $id, ['class' => 'val-' . \yii\helpers\Inflector::slug($value)]);
            }]); ?>
        </div>

        <?= $form->field($model, 'comment')->textarea(['rows' => 3]); ?>

        <div class="line text-center">
            <button type="submit" class="button">отправить</button>
        </div>
    </div>

<? ActiveForm::end(); ?>