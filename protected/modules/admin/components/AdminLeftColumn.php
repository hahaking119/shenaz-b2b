<?php

class AdminLeftColumn extends CWidget {

    public function init() {
        
    }

    public function run() {
        $controller = Yii::app()->controller->id;
        $action = Yii::app()->controller->action->id;
        $arr = array(
            array('label' => 'Dashboard', 'url' => array('login/dashboard'), 'itemOptions' => array('class' => ($controller == 'login') ? 'active' : '')),
            array('label' => 'Members', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'member') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Members', 'url' => array('member/admin'),
                        'itemOptions' => array('class' => ($controller == 'member' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Member', 'url' => array('member/create'),
                        'itemOptions' => array('class' => ($controller == 'member' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Products', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'product') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Products', 'url' => array('product/admin'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Product', 'url' => array('product/create'),
                        'itemOptions' => array('class' => ($controller == 'product' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Categories', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'category') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Categories', 'url' => array('category/admin'),
                        'itemOptions' => array('class' => ($controller == 'category' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Category', 'url' => array('category/create'),
                        'itemOptions' => array('class' => ($controller == 'category' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Administrators', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'administrator') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Administrators', 'url' => array('administrator/admin'),
                        'itemOptions' => array('class' => ($controller == 'administrator' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Administrator', 'url' => array('administrator/create'),
                        'itemOptions' => array('class' => ($controller == 'administrator' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Newsletters', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'newsletters') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Newsletters', 'url' => array('Newsletters/admin'),
                        'itemOptions' => array('class' => ($controller == 'newsletters' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Create Newsletter', 'url' => array('Newsletters/create'),
                        'itemOptions' => array('class' => ($controller == 'newsletters' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Membership', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => ($controller == 'membership') ? 'parent-menu active ' . $controller : 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Membership', 'url' => array('membership/admin'),
                        'itemOptions' => array('class' => ($controller == 'membership' && $action == 'admin') ? 'child-menu active' : 'child-menu')),
                    array('label' => 'Add Membership', 'url' => array('membership/create'),
                        'itemOptions' => array('class' => ($controller == 'membership' && $action == 'create') ? 'child-menu active' : 'child-menu')),
                )
            ),
            array('label' => 'Logout', 'url' => array('login/logout')),
        );

        $this->render('AdminLeftColumn', array('arr' => $arr));
    }

}
