<?php

class LoginController extends Controller {

    public $layout = "//layouts/column1";

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to access 'index' and 'login' actions.
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to access 'index' and 'login' actions.
                'actions' => array('dashboard', 'logout'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array('dashboard'));
            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionDashboard() {
        $this->layout = "//layouts/column2";
        $model = Administrator::model()->findByPk(Yii::app()->user->getId());
        $this->render('dashboard', array('model' => $model));
    }

}
