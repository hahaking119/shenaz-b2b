<?php

class ShoppingCartController extends CController {

    public function actionAddToCart() {
        if (isset(Yii::app()->session['shopping_list'])) {
            $cart = Yii::app()->session['shopping_list'];
        } else {
            $cart = '';
        }

        if (!is_numeric($_POST['qty']) || $_POST['qty'] <= 0) {
            Yii::app()->user->setFlash('error', '<strong>Illegal quantity given.</strong>');
            echo 'illegal';
            Yii::app()->end();
        }
        foreach ($cart as $key => $value) {
            if ($value['product_id'] == $_POST['product_id']) {
                $cart_index = $key;
            }
            if (isset($cart_index)) {
                $cart[$cart_index]['qty'] += $_POST['qty'];
            } else {
                $cart[] = $_POST;
            }
        }
        Yii::app()->session['shopping_list'] = $cart;
    }

    public function actionGetCartItems() {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-transition.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-tooltip.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-popover.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-modal.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-alert.js'] = false;
        $this->renderPartial('cart', '', false, true);
    }

}
