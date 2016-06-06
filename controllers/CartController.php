<?php

namespace app\controllers;

use app\models\Order;
use app\models\Shop;
use Yii;
use yii\web\HttpException;

class CartController extends \yii\web\Controller
{
    public function actionAdd($id = null)
    {
        $model = Shop::findOne(Yii::$app->request->post('id', $id));
        if (is_null($model))
            throw new HttpException(404, 'Product not found');

        Yii::$app->cart->update($model, Yii::$app->request->post('quantity', 1));
        if (!Yii::$app->request->isAjax)
            return $this->redirect(['index']);
    }

    public function actionRemove($id)
    {
        $model = Shop::findOne($id);
        if (is_null($model))
            throw new HttpException(404, 'Product not found');

        Yii::$app->cart->update($model, 0);
        return $this->goBack(['cart/index']);
    }

    public function actionClear()
    {
        Yii::$app->cart->clear();
        return $this->goBack('/');
    }

    public function actionBack()
    {
        return $this->goBack('/');
    }

    public function actionIndex()
    {
        $this->getView()->title = 'Корзина';
        return $this->render('index');
    }

    public function actionSend()
    {
        $this->getView()->title = 'Оформление заказа';
        $model = new Order();

        if(!Yii::$app->cart->getCost()){
            Yii::$app->session->setFlash('warning', 'Вы не можете оформить пустой заказ.');
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cart->toOrder($model->id);
            $this->redirect(['success', 'id' => $model->id]);
        }

        return $this->render('send', ['model' => $model]);
    }

    public function actionSuccess($id)
    {
        $this->getView()->title = 'Заказ успешно оформлен';
        $model = Order::findOne($id);
        return $this->render('success', ['model' => $model]);
    }

}
