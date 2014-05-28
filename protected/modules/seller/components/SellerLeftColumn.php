<?php

class SellerLeftColumn extends CWidget {

    public function init() {
        
    }

    public function run() {
        $controller = Yii::app()->controller->id;
        $action = Yii::app()->controller->action->id;
        $arr = array(
            array('label' => 'Dashboard', 'url' => array('login/dashboard'), 'itemOptions' => array('class' => ($controller == 'login') ? 'active' : '')),
            array('label' => 'Profile', 'url' => array('member/profile'), 'itemOptions' => array('class' => ($controller == 'login') ? 'active' : '')),
            array('label' => 'Products', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'product') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Products', 'url' => array('product/admin'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Product', 'url' => array('product/create'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Custom Categories', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'custom categories') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Custom Categories', 'url' => array('customCategory/admin'),
                        'itemOptions' => array('class' => ($controller == 'custom categories' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Custom Category', 'url' => array('customCategory/create'),
                        'itemOptions' => array('class' => ($controller == 'custom categories' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Email', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'email') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Emails', 'url' => array('email/admin'),
                        'itemOptions' => array('class' => ($controller == 'custom categories' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Compose', 'url' => array('email/create'),
                        'itemOptions' => array('class' => ($controller == 'custom categories' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Edit Company and Directory Information', 'url' => array('directoryInformation/add_directory_company_info')),
            array('label' => 'Setting', 'url' => array('member/setting')),
            array('label' => 'Logout', 'url' => array('login/logout')),
        );

        $this->render('SellerLeftColumn', array('arr' => $arr));
    }

}
