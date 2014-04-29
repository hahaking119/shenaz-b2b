<?php

class DefaultController extends Controller {
    
    public $theme = '//layouts/column1';

    public function actionIndex() {
        $this->render(Yii::app()->createAbsoluteUrl('admin/login'));
    }

}
