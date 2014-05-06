<?php

class MemberController extends Controller
{
    public $layout = '//layouts/column2';
    
    public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}
    
    public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('setting','profile'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    public function actionSetting() {
        $this->layout = '//layouts/column2';
        $id = Yii::app()->user->getId();
        $model = MemberSetting::model()->findByAttributes(array('member_id' => $id));
        if (!$model) {
            $model = new MemberSetting;
        }
        $membership = Membership::model()->findAllByAttributes(array('status' => 1, 'trash' => 0));
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'setting-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['MemberSetting'])) {
            $model->attributes = $_POST['MemberSetting'];
            $model->member_id = $id;
            if($model->isNewRecord)
                $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The setting has been updated.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }
        $this->render('_setting', array('model' => $model, 'membership' => $membership));
    }
    
    public function actionProfile() {
        $id = Yii::app()->user->getId();
        $model = $this->loadModel($id);
        $model->db_password_text = $model->password_text;
        $subscriber = NewsletterSubscriber::model()->findByAttributes(array('member_id' => $id));
        if (!$subscriber) {
            $subscriber = new NewsletterSubscriber();
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($_POST['NewsletterSubscriber'])) {
                    if ($_POST['NewsletterSubscriber']['id'] == 1) {
                        $subscriber = NewsletterSubscriber::model()->findByAttributes(array('member_id' => $model->member_id));
                        if (!$subscriber) {
                            $subscriber = new NewsletterSubscriber();
                            $subscriber->member_id = $model->member_id;
                            $subscriber->email = $model->email;
                            $subscriber->save();
                        }
                    } else {
                        if(!$subscriber->isNewRecord)
                            $subscriber->delete($subscriber->id);
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> Your profile has been updated.');
                $this->redirect(array('profile', 'id' => $model->member_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('profile', array(
            'model' => $model,
            'subscriber' => $subscriber
        ));
    }
    
    public function loadModel($id) {
        $model = Member::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}