<?php

class Header extends CWidget {

    public function init() {
        
    }

    public function run() {
        $model = new LoginForm;
        if (Yii::app()->user->isGuest) {
            $member = new Member;
        } else {
            $member = Member::model()->findByPk(Yii::app()->user->getId());
        }
        $categories = Category::model()->findAll('parent_id = 0 and status = 1 and trash = 0');
        $this->render('Header', array('model' => $model, 'member' => $member, 'categories' => $categories));
    }

}
