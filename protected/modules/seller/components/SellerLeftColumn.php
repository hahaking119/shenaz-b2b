<?php

class SellerLeftColumn extends CWidget {

    public function init() {
        
    }

    public function run() {
        $controller = Yii::app()->controller->id;
        $action = Yii::app()->controller->action->id;
        $arr = array(
            array('label' => 'Dashboard', 'url' => array('login/dashboard'), 'itemOptions' => array('class' => ($controller == 'login') ? 'active' : '')),
            array('label' => 'Products', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'product') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Products', 'url' => array('product/admin'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Product', 'url' => array('product/create'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Logout', 'url' => array('login/logout')),
        );

        $this->render('SellerLeftColumn', array('arr' => $arr));
    }

}
