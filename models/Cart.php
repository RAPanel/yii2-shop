<?php

namespace ra\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property Order $order
 * @property float $total
 */
class Cart extends \ra\models\db\Cart
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'dataSerialization' => [
                'class' => '\yii\behaviors\AttributeBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'data',
                    self::EVENT_BEFORE_UPDATE => 'data',
                    self::EVENT_AFTER_INSERT => 'data',
                    self::EVENT_AFTER_UPDATE => 'data',
                    self::EVENT_AFTER_FIND => 'data',
                ],
                'value' => function ($event) {
                    if ($this->data && is_object($this->data)) return serialize($this->data);
                    else return $this->data && is_string($this->data) ? unserialize($this->data) : null;
                },
            ],
        ];
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->price * $this->quantity;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
