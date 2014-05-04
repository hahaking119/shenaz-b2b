<?php
Yii::app()->theme = "seller";
class SellerModule extends CWebModule {
    
    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'seller.models.*',
            'seller.components.*',
        ));
        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'seller/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'stateKeyPrefix' => '_seller',
                'loginUrl' => Yii::app()->createUrl('seller/login'),
            )
        ));
        Yii::app()->user->setStateKeyPrefix('_seller');
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            $route = $controller->id . '/' . $action->id;
            $publicPages = array(
                'login/index',
                'login/login',
                'default/error',
            );
            if (Yii::app()->user->isGuest && !in_array($route, $publicPages)) {
                Yii::app()->getModule('seller')->user->loginRequired();
            } else {
                return true;
            }
        } else
            return false;
    }

}
