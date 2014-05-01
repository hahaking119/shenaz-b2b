<?php

class DefaultController extends Controller {

    public $theme = '//layouts/column1';

    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/login'));
        } else {
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/login/dashboard'));
        }
    }

}
