<?php

class LeftMenu extends CWidget {

    public function init() {
        
    }

    public function run() {
//        $categories = Category::model()->findAll('parent_id = 0 and status = 1 and trash = 0', array('order' => 'title ASC'));
        $categories = Category::model()->findAllByAttributes(array('parent_id' => 0, 'status' => 1, 'trash' => 0),array('order' => 'title ASC'));
        $this->render('LeftMenu', array('categories' => $categories));
    }

}
