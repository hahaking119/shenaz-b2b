<?php

class ShoppingCartController extends CController {

    public function init() {

        parent::init();
        if (Yii::app()->user->isGuest)
            Yii::app()->theme = 'default';
        else {
//            Yii::app()->theme = 'classic';
            Yii::app()->theme = 'default';
        }
    }

    public $layout = '//layouts/column2';

    public function actionAddToCart() {
        $cart = Yii::app()->session['shopping_list'];

        if (!is_numeric($_POST['qty']) || $_POST['qty'] <= 0) {
            Yii::app()->user->setFlash('error', '<strong>Illegal quantity given.</strong>');
            echo 'illegal';
            Yii::app()->end();
        } else {
            // remove potential clutter
            if (isset($_POST['yt0']))
                unset($_POST['yt0']);
            if (isset($_POST['yt1']))
                unset($_POST['yt1']);
            if (!empty($cart)) {
                foreach ($cart as $key => $value) {
                    if ($value['product_id'] == $_POST['product_id']) {
                        $cart_index = $key;
                    }
                }
                if (isset($cart_index)) {
                    $cart[$cart_index]['qty'] += $_POST['qty'];
                } else {
                    $cart[] = $_POST;
                }
            } else {
                $cart[] = $_POST;
            }
            Yii::app()->session['shopping_list'] = $cart;
        }
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

    public function actionView() {
        $products = Yii::app()->session['shopping_list'];
        $this->render('view', array('products' => $products));
    }

    public function actionRemove() {
        if (isset($_POST['product_id'])) {
            $cart = Yii::app()->session['shopping_list'];
            foreach ($cart as $key => $value) {
                if ($value['product_id'] == $_POST['product_id']) {
                    $cart_index = $key;
                }
            }
            if (isset($cart_index)) {
                unset($cart[$cart_index]);
            }
            Yii::app()->session['shopping_list'] = $cart;
            echo 'success';
            Yii::app()->end();
        }
    }

    public function actionUpdateQuantity() {
        if (isset($_POST['product_id'])) {
            $cart = Yii::app()->session['shopping_list'];
            foreach ($cart as $key => $value) {
                if ($value['product_id'] == $_POST['product_id']) {
                    $cart_index = $key;
                }
            }
            if (isset($cart_index)) {
                $cart[$cart_index]['qty'] = $_POST['qty'];
            }
            Yii::app()->session['shopping_list'] = $cart;
            echo 'success';
            Yii::app()->end();
        }
    }

    public function actionCheckout() {
        $this->redirect(Yii::app()->createAbsoluteUrl('order/create'));
    }

}
