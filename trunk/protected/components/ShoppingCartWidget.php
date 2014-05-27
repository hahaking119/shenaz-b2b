
<?php
Yii::import('zii.widgets.CPortlet');
//Yii::app()->getModule('shop');

class ShoppingCartWidget extends CPortlet {

    public function init() {
        return parent::init();
    }

    public function run() {
        $this->render('shopping_cart', array(
            'products' => Yii::app()->session['shopping_list']));

        return parent::run();
    }

}
?>