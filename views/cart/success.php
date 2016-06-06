<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.09.2015
 * Time: 18:44
 */

?>

<section class="main">
    <div class="basketPage">
        <div class="row">
            <div class="column">
                <h1 class="header"><?= $this->title ?></h1>

                <p>Спасибо за Ваш заказ.</p>

                <p>Наш менеджер свяжется с Вами в ближайшее время, чтобы уточнить все детали.</p>

                <?if($model->pay_id == 9):?>

                    <h2>Оплатить заказ</h2>

                    <?= $this->render('//pay/yandex', ['merchant'=>Yii::$app->merchants->get('yandex'), 'model'=>Yii::$app->merchants->get('yandex')->model($model->id)]) ?>

                <?endif?>

            </div>
        </div>
    </div>
</section>