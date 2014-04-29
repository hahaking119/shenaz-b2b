<?php

class AdminLeftColumn extends CWidget {

    public function init() {
        
    }

    public function run() {
        $arr = array(
            array('label' => 'Dashboard', 'url' => array('login/dashboard')),
            array('label' => 'Members', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Members', 'url' => array('member/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Add Member', 'url' => array('member/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Products', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Products', 'url' => array('product/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Add Product', 'url' => array('member/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Categories', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Categories', 'url' => array('category/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Add Category', 'url' => array('category/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Administrators', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Administrators', 'url' => array('administrator/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Add Administrator', 'url' => array('administrator/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Newsletters', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Newsletters', 'url' => array('Newsletters/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Create Newsletter', 'url' => array('Newsletters/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Membership', 'url' => 'javascript:void(0)',
                'itemOptions' => array('class' => 'parent-menu'),
                'items' => array(
                    array('label' => 'Manage Membership', 'url' => array('membership/admin'),
                        'itemOptions' => array('class' => 'child-menu')),
                    array('label' => 'Add Membership', 'url' => array('membership/create'),
                        'itemOptions' => array('class' => 'child-menu'))
                )
            ),
            array('label' => 'Logout', 'url' => array('login/logout')),
        );

        $this->render('AdminLeftColumn', array('arr' => $arr));
    }

}
