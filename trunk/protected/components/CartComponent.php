<?php

class CartComponent extends CComponent {

    public static function getCartTotal() {
        if (isset(Yii::app()->session['shopping_list'])) {
            $cart = Yii::app()->session['shopping_list'];
            $total = 0;
            foreach ($cart as $item) {
                $product = Product::model()->findByPk($item['product_id']);
                $total +=($product->price * $item['qty']);
            }
            return $total;
        } else {
            return FALSE;
        }
    }

}
