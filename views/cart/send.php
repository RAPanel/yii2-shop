<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.09.2015
 * Time: 18:44
 */
use yii\helpers\Html;

?>

<div class="row">
    <div class="column">
        <div class="orderPage">

            <?= Html::errorSummary($model) ?>

            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
    </div>
</div>
