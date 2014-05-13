<?php

class LeftMenu extends CWidget {

    public function init() {
        
    }

    public function run() {
        $categories = Category::model()->findAll('parent_id = 0 and status = 1 and trash = 0');
        $this->render('LeftMenu', array('categories' => $categories));
    }

}
